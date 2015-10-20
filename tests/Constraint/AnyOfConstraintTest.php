<?php

namespace JsonSchema\Constraint;

use JsonSchema\Constraint;
use JsonSchema\Context;
use JsonSchema\Testing\ConstraintTestCase;

class AnyOfConstraintTest extends ConstraintTestCase
{
    public function testNormalizeIfAnyOfIsNotArray()
    {
        $this->expectConstraintException('InvalidTypeException', '/anyOf');
        $schema = $this->loadSchema('invalid/anyOf-not-array');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeThrowsIfAnyOfIsEmpty()
    {
        $this->expectConstraintException('EmptyArrayException', '/anyOf');
        $schema = $this->loadSchema('invalid/anyOf-empty');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeThrowsIfAnyOfElementIsNotObject()
    {
        $this->expectConstraintException('InvalidTypeException', '/anyOf/2');
        $schema = $this->loadSchema('invalid/anyOf-element-not-object');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeEnsureEverySubSchemaIsValid()
    {
        $schema = $this->loadSchema('valid/anyOf-valid-sub-schemas');
        $walker = $this->mockWalker();
        $walker->expects($this->exactly(2))
            ->method('parseSchema')
            ->withConsecutive($schema->anyOf[0], $schema->anyOf[1]);
        $this->getConstraint()->normalize($schema, new Context(), $walker);
    }

    protected function getConstraint()
    {
        return new AnyOfConstraint();
    }

    protected function getCaseFileNames()
    {
        return ['anyOf'];
    }
}