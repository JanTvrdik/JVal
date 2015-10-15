<?php

namespace JsonSchema;

use JsonSchema\Constraint;
use stdClass;

class Validator
{
    /**
     * @var ConstraintInterface[]
     */
    private $constraints;

    public function __construct()
    {  
       $this->constraints = [
           new Constraint\MultipleOfConstraint(),
           new Constraint\MaximumConstraint(),
           new Constraint\MaxItemsConstraint(),
           new Constraint\ItemsConstraint(),
           new Constraint\MaxPropertiesConstraint()
       ];
    }

    public function validate($instance, stdClass $schema)
    {
        $context = new Context();
        $this->doValidate($instance, $schema, $context);

        return $context->getViolations();
    }

    // validator doesn't enforce schema correctness during normal
    // data validation : its behaviour is undefined if schema
    // is invalid
    public function validateSchema(stdClass $schema)
    {
        // get spec schema
        // doValidate($schema, $specSchema, [...])
    }

    private function doValidate($instance, stdClass $schema, Context $context)
    {
        // call set node here ?

        if (isset($schema->definitions)) {
            // store sub schemas
        }

        foreach ($this->constraints as $constraint) {
            if ($constraint->isApplicableTo($instance)) {
                foreach ($constraint->keywords() as $keyword) {
                    if (isset($schema->{$keyword})) {
                        $constraint->apply($instance, $schema, $context);
                        break;
                    }
                }
            }
        }


        // providers:
        // OfProvider (allOf, anyOf, oneOf)
        // NotProvider
        // DependenciesProvider(schema dependencies >< property dependencies)

        // loop on providers
        // provider->collect(instance, schema)
        // while provider->hasSchema()
        // provider->popSchema()
        // validate in new context
        // 


        // child (item, property) provider ? => iterator
        // ItemIterator
        // PropertyIterator
    }
}