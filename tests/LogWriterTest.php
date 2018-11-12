<?php
namespace App\Tests;

use App\Service\Interfaces\LogWriterInterface;
use App\Service\LogWriter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;

class LogWriterTest extends WebTestCase
{
    /**
     * @var LogWriterInterface
     */
    protected $logWriter;


    protected function setUp()
    {
        $containerMock = self::bootKernel()->getContainer();
        $this->logWriter = new LogWriter($containerMock);
    }

    public function testCreateFile()
    {
        $this->logWriter->createFile('test.txt');
        $this->assertFileExists(self::bootKernel()->getLogDir() . DIRECTORY_SEPARATOR . 'test.txt');
    }

    public function testAppendContent()
    {
        $this->testCreateFile();
        $this->logWriter->appendContent('test');
        $file = self::bootKernel()->getLogDir() . DIRECTORY_SEPARATOR . 'test.txt';
        $text = file_get_contents($file);
        $this->assertContains('test', $text);
    }

    public function testAppendContentToFile()
    {
        $this->testCreateFile();
    }

    public static function tearDownAfterClass()
    {
        $file = self::bootKernel()->getLogDir() . DIRECTORY_SEPARATOR . 'text.txt';
        $filesystem = new Filesystem();

        if ($filesystem->exists($file)) {
            $filesystem->remove($file);
        }
    }
}
