<?php

use PHPUnit\Framework\TestCase;
use Project_calculator\Classes\Calculator;

class CalculatorTest extends TestCase
{
    // --- Negative add tests (3) ---
    public function testAddTwoNegativeNumbers()
    {
        $calculator = new Calculator();
        $this->assertEquals(-8, $calculator->add(-5, -3));
    }

    public function testAddNegativeAndPositiveNumber()
    {
        $calculator = new Calculator();
        $this->assertEquals(-2, $calculator->add(-5, 3));
    }

    public function testAddNegativeWithZero()
    {
        $calculator = new Calculator();
        $this->assertEquals(-5, $calculator->add(-5, 0));
    }

    // --- Subtract tests (3) ---
    public function testSubtractTwoPositiveNumbers()
    {
        $calculator = new Calculator();
        $this->assertEquals(2, $calculator->subtract(5, 3));
    }

    public function testSubtractWithNegative()
    {
        $calculator = new Calculator();
        $this->assertEquals(8, $calculator->subtract(5, -3));
    }

    public function testSubtractResultsInZero()
    {
        $calculator = new Calculator();
        $this->assertEquals(0, $calculator->subtract(3, 3));
    }

    // --- Multiply tests (3) ---
    public function testMultiplyTwoPositiveNumbers()
    {
        $calculator = new Calculator();
        $this->assertEquals(20, $calculator->multiply(4, 5));
    }

    public function testMultiplyByZero()
    {
        $calculator = new Calculator();
        $this->assertEquals(0, $calculator->multiply(7, 0));
    }

    public function testMultiplyWithNegative()
    {
        $calculator = new Calculator();
        $this->assertEquals(-20, $calculator->multiply(-4, 5));
    }

    // --- Divide tests (3) ---
    public function testDivideTwoPositiveNumbers()
    {
        $calculator = new Calculator();
        $this->assertEquals(2, $calculator->divide(6, 3));
    }

    public function testDivideWithFloatResult()
    {
        $calculator = new Calculator();
        $this->assertEqualsWithDelta(2.5, $calculator->divide(5, 2), 0.00001);
    }

    public function testDivideByZeroReturnsNull()
    {
        $calculator = new Calculator();
        $this->assertNull($calculator->divide(5, 0));
    }
}