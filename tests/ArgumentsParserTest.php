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
}
