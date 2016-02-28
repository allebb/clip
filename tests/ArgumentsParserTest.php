<?php
use Ballen\Clip\Utilities\CommandRouter;
use Ballen\Clip\ConsoleApplication;
use Ballen\Clip\Traits\RecievesArgumentsTrait;
use Ballen\Clip\Interfaces\CommandInterface;

class ArgumentsParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Extended example $argv array, excute being 'php env add --DB_USER="ballen" --DB_PASS="my_password_here" --quiet --no-interaction -yRf'
     * @var array
     */
    private $argv_example2 = ['env', 'add', '--DB_USER=ballen', '--DB_PASS="my password here"', '--quiet', '--no-interaction', '-yRf'];

    public function testGetCommands()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertEquals(2, $app->commands()->count());
    }

    public function testGetCommandIndex()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertEquals('env', $app->commands()->get(0));
    }

    public function testGetSecondCommandIndex()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertEquals('add', $app->commands()->get(1));
    }

    public function testGetCommandsFromEmptyArgv()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser();
        $this->assertEquals(0, $app->commands()->count());
    }

    public function testTotalOptions()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertEquals(2, $app->options()->count());
    }

    public function testGetOptions()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertEquals([
            'DB_USER' => 'ballen',
            'DB_PASS' => 'my password here',
            ], $app->options()->all()->toArray());
    }

    public function testGetSpecificOption()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertEquals('my password here', $app->getOption('DB_PASS'));
        $this->assertEquals('localhost', $app->getOption('DB_HOST', 'localhost'));
    }

    public function testTotalFlags()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertEquals(5, $app->flags()->count());
    }

    public function testGetFlags()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertEquals([
            'quiet',
            'no-interaction',
            'y',
            'R',
            'f',
            ], $app->flags()->all()->toArray());
    }

    public function testTotalArgs()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertEquals(7, $app->arguments()->count());
    }

    public function testGetArgs()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertEquals([
            'env',
            'add',
            '--DB_USER=ballen',
            '--DB_PASS="my password here"',
            '--quiet',
            '--no-interaction',
            '-yRf',
            ], $app->arguments()->all()->toArray());
    }

    public function testFlagSet()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertTrue($app->isFlagSet('y'));
        $this->assertTrue($app->isFlagSet('R'));
        $this->assertFalse($app->isFlagSet('z'));
        $this->assertTrue($app->isFlagSet('no-interaction'));
        $this->assertFalse($app->isFlagSet('i'));
    }

    public function testValidOptionsSet()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertTrue($app->requiredOptions(['DB_USER', 'DB_PASS']));
        $this->assertTrue($app->requiredOptions(['DB_USER']));
        $this->assertTrue($app->requiredOptions());
    }

    public function testInvalidOptionsSet()
    {
        $app = new Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2);
        $this->assertFalse($app->requiredOptions(['DB_USER', 'NON_SET_OPTION']));
        $this->assertFalse($app->requiredOptions(['INVALID_OPTION', 'NON_SET_OPTION']));
    }
}
