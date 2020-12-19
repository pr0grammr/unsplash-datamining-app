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
        'nbxffbJKPYc' => InputResolver::TYPE_PHOTO,
        '@chewy' => InputResolver::TYPE_USER,
        '@_______life_' => InputResolver::TYPE_USER,
        '-mu7gP2Y-VM' => InputResolver::TYPE_PHOTO,
        '5bv5n4nwmRk' => InputResolver::TYPE_PHOTO
    ];

    /**
     * key-value array von test usernames und ihr erwarteter output bei der InputResolver::stripUsername methode
     */
    const TEST_USERNAMES = [
        'fabianschilf' => 'fabianschilf',
        '@yeapea' => 'yeapea'
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->inputResolver = app(InputResolver::class);
    }

    /**
     * test InputResolver::resolveInput
     */
    public function testResolveInput()
    {
        foreach (self::TEST_INPUTS_RAW as $rawInput => $expectedInput) {
            $strippedInput = $this->inputResolver->resolveInput($rawInput);
            $this->assertEquals($expectedInput, $strippedInput);
        }
    }

    /**
     * test InputResolver::resolveType
     */
    public function testResolveType()
    {
        foreach (self::TEST_INPUTS_TYPES as $rawInput => $expectedType) {
            $type = $this->inputResolver->resolveType($rawInput);
            $this->assertEquals($expectedType, $type);
        }
    }

    /**
     * test InputResolver::stripUsername
     */
    public function testStripUsername()
    {
        foreach (self::TEST_USERNAMES as $rawUsername => $expectedUsername) {
            $username = $this->inputResolver->stripUsername($rawUsername);
            $this->assertEquals($expectedUsername, $username);
        }
    }
}
