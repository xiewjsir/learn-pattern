<?php

// 解释器模式

abstract class Expression {

    private static $keyCount = 0;
    private $key = NULL;

    abstract function interpret(InterpreterContext $ctx);

    /**
     * as array key
     * @return auto increment value
     */
    public function getKey() {
        if (!isset($this->key)) {
            self::$keyCount++;
            $this->key = self::$keyCount;
        }
        return $this->key;
    }

}

/**
 * context
 */
class InterpreterContext {

    private $expressionstore = array();

    /**
     * store value
     */
    public function replace(Expression $exp, $value) {
        $this->expressionstore[$exp->getKey()] = $value;
    }

    /**
     * find value
     */
    public function lookup(Expression $exp) {
        return $this->expressionstore[$exp->getKey()];
    }

}

/**
 * literal expression
 */
class LiteralExpression extends Expression {

    private $value;

    public function construct($value) {
        $this->value = $value;
    }

    public function interpret(InterpreterContext $ctx) {
        $ctx->replace($this, $this->value);
    }

}

/**
 * var=value expression
 */
class VariableExpression extends Expression {

    private $name;
    private $val;

    public function construct($name, $val = null) {
        $this->name = $name;
        $this->val = $val;
    }

    public function interpret(InterpreterContext $ctx) {
        if (!is_null($this->val)) {
            $ctx->replace($this, $this->val);
            $this->val = null;
        }
    }

    public function setValue($value) {
        $this->val = $value;
    }

    /**
     * @override
     */
    public function getKey() {
        return $this->name;
    }

}

abstract class OperatorExpression extends Expression {

    protected $l_op;
    protected $r_op;

    public function construct(Expression $l, Expression $r) {
        $this->l_op = $l;
        $this->r_op = $r;
    }

    /**
     * @param $ctx       InterpreterContext
     * @param $result_l  Expression $l's result
     * @param $result_r  Expression $r's result
     */
    protected abstract function doInterpret(InterpreterContext $ctx, $result_l, $result_r);

    public function interpret(InterpreterContext $ctx) {
        $this->l_op->interpret($ctx);
        $this->r_op->interpret($ctx);
        $result_l = $ctx->lookup($this->l_op);
        $result_r = $ctx->lookup($this->r_op);
        $this->doInterpret($ctx, $result_l, $result_r);
    }

}

/**
 * equals
 */
class EqualsExpression extends OperatorExpression {

    protected function doInterpret(InterpreterContext $ctx, $result_l, $result_r) {
        $ctx->replace($this, $result_l == $result_r);
    }

}

/**
 * or
 */
class BooleanOrExpression extends OperatorExpression {

    protected function doInterpret(InterpreterContext $ctx, $result_l, $result_r) {
        $ctx->replace($this, $result_l || $result_r);
    }

}

/**
 * and
 */
class BooleanAndExpression extends OperatorExpression {

    protected function doInterpret(InterpreterContext $ctx, $result_l, $result_r) {
        $ctx->replace($this, $result_l && $result_r);
    }

}

/**
 * not
 */
class BooleanNotExpression extends Expression {

    private $expr;

    public function construct(Expression $e) {
        $this->expr = $e;
    }

    public function interpret(InterpreterContext $ctx) {
        $this->expr->interpret($ctx);
        $ctx->replace($this, !$ctx->lookup($this->expr));
    }

}

// test code
/*
  $ctx = new InterpreterContext();
  $literarl = new LiteralExpression('four');
  $literarl->interpret($ctx);
  // echo $ctx->lookup($literarl);

  $variable = new VariableExpression('input', '444');
  $variable->interpret($ctx);
  // echo $ctx->lookup($variable);

  $answer = new VariableExpression('input');
  $answer->interpret($ctx);
  echo $ctx->lookup($answer);
 */

// $input equas four or $input equals 4
$ctx = new InterpreterContext();

$input = new VariableExpression('input');
$statement = new BooleanOrExpression(
        new EqualsExpression($input, new LiteralExpression('four')), new EqualsExpression($input, new LiteralExpression(4))
);

$input->setValue('four');
$statement->interpret($ctx);
var_dump($ctx->lookup($statement)); // true

$input->setValue(4);
$statement->interpret($ctx);
var_dump($ctx->lookup($statement)); // true

$input->setValue(42);
$statement->interpret($ctx);
var_dump($ctx->lookup($statement)); // false

$not = new BooleanNotExpression($statement); // true
$not->interpret($ctx);
var_dump($ctx->lookup($not));
