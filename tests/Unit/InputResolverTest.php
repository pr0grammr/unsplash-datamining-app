<?php


namespace Tests\Unit;


use App\Unsplash\InputResolver;
use PHPUnit\Framework\TestCase;

class InputResolverTest extends TestCase
{
    /**
     * @var InputResolver
     */
    private $inputResolver;

    const STRIP_TEST_INPUTS = [
        'https://unsplash.com/@yeapea' => '@yeapea',
        'https://www.unsplash.com/@fabianschilf' => '@fabianschilf',
        'https://unsplash.com/photos/nbxffbJKPYc' => 'nbxffbJKPYc',
        '@chewy' => '@chewy',
        'https://unsplash.com/@_______life_' => '@_______life_',
        'https://unsplash.com/photos/-mu7gP2Y-VM' => '-mu7gP2Y-VM',
        'https://unsplash.com/photos/5bv5n4nwmRk' => '5bv5n4nwmRk'
    ];

    const TYPE_TEST_INPUTS = [
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

    public function testStripInput()
    {
        foreach (self::STRIP_TEST_INPUTS as $rawInput => $expectedInput) {
            $strippedInput = $this->inputResolver->stripInput($rawInput);
            $this->assertEquals($expectedInput, $strippedInput);
        }
    }

    public function testResolveType()
    {
        foreach (self::TYPE_TEST_INPUTS as $rawInput => $expectedType) {
            $type = $this->inputResolver->resolveType($rawInput);
            $this->assertEquals($expectedType, $type);
        }
    }
}
