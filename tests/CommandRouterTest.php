<?php
use Ballen\Clip\ConsoleApplication;
use Ballen\Clip\Traits\RecievesArgumentsTrait;
use Ballen\Clip\Interfaces\CommandInterface;
use PHPUnit\Framework\TestCase;

class CommandRouterTest extends TestCase
{

    /**
     * Extended example $argv array, excute being 'php env add --DB_USER="ballen" --DB_PASS="my_password_here" --quiet --no-interaction -yRf'
     * @var array
     */
    private $argv_example2 = ['env', 'add', '--DB_USER=ballen', '--DB_PASS="my password here"', '--quiet', '--no-interaction', '-yRf'];

    public function testCreateNewApplication()
    {
        $app = new ConsoleApplication(new \Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2));
        $this->assertEquals(7, $app->arguments()->arguments()->count());
    }

    public function testApplicationRouterInstance()
    {
        $app = new ConsoleApplication(new \Ballen\Clip\Utilities\ArgumentsParser($this->argv_example2));
        $this->assertInstanceOf(Ballen\Clip\Utilities\CommandRouter::class, $app->router());
    }
}
