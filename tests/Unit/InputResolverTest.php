<?php


namespace Tests\Unit;


use App\Unsplash\InputResolver;
use PHPUnit\Framework\TestCase;


/**
 * Class InputResolverTest
 * @package Tests\Unit
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class InputResolverTest extends TestCase
{
    /**
     * @var InputResolver
     */
    private $inputResolver;

    /**
     * key-value array of test inputs and their expected output
     */
    const TEST_INPUTS_RAW = [
        'https://unsplash.com/@yeapea' => '@yeapea',
        'https://www.unsplash.com/@fabianschilf' => '@fabianschilf',
        'https://unsplash.com/photos/nbxffbJKPYc' => 'nbxffbJKPYc',
        '@chewy' => '@chewy',
        'https://unsplash.com/@_______life_' => '@_______life_',
        'https://unsplash.com/photos/-mu7gP2Y-VM' => '-mu7gP2Y-VM',
        'https://unsplash.com/photos/5bv5n4nwmRk' => '5bv5n4nwmRk'
    ];

    /**
     * key-value array of test identifier with their expected type
     */
    const TEST_INPUTS_TYPES = [
        '@yeapea' => InputResolver::TYPE_USER,
        '@fabianschilf' => InputResolver::TYPE_USER,
        'nbxffbJKPYc' => InputResolver::TYPE_IMAGE,
        '@chewy' => InputResolver::TYPE_USER,
        '@_______life_' => InputResolver::TYPE_USER,
        '-mu7gP2Y-VM' => InputResolver::TYPE_IMAGE,
        '5bv5n4nwmRk' => InputResolver::TYPE_IMAGE
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->inputResolver = app(InputResolver::class);
    }

    /**
     * test resolving inputs
     */
    public function testResolveInput()
    {
        foreach (self::TEST_INPUTS_RAW as $rawInput => $expectedInput) {
            $strippedInput = $this->inputResolver->resolveInput($rawInput);
            $this->assertEquals($expectedInput, $strippedInput);
        }
    }

    /**
     * test resolving type of input
     */
    public function testResolveType()
    {
        foreach (self::TEST_INPUTS_TYPES as $rawInput => $expectedType) {
            $type = $this->inputResolver->resolveType($rawInput);
            $this->assertEquals($expectedType, $type);
        }
    }
}
