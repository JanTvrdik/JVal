<?php

namespace JsonSchema\Constraint;

use JsonSchema\Constraint;
use JsonSchema\Context;
use JsonSchema\Testing\ConstraintTestCase;

class MinimumTest extends ConstraintTestCase
{
      public function testNormalizeThrowsIfMaxNotPresent()
    {
        $this->expectConstraintException('MissingKeywordException', '', 'minimum');
        $schema = $this->loadSchema('invalid/minimum-not-present');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeSetsExclusiveMaxToFalseIfNotPresent()
    {
        $schema = $this->loadSchema('valid/exclusiveMinimum-not-present');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
        $this->assertObjectHasAttribute('exclusiveMinimum', $schema);
        $this->assertEquals(false, $schema->exclusiveMinimum);
    }

    public function testNormalizeThrowsIfMinimumIsNotANumber()
    {
        $this->expectConstraintException('InvalidTypeException', '/minimum');
        $schema = $this->loadSchema('invalid/minimum-not-number');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    public function testNormalizeThrowsIfExclusiveMinimumIsNotABoolean()
    {
        $this->expectConstraintException('InvalidTypeException', '/exclusiveMinimum');
        $schema = $this->loadSchema('invalid/exclusiveMinimum-not-boolean');
        $this->getConstraint()->normalize($schema, new Context(), $this->mockWalker());
    }

    protected function getConstraint()
    {
        return new MinimumConstraint();
    }

    protected function getCaseFileNames()
    {
        return ['minimum'];
    }
}
