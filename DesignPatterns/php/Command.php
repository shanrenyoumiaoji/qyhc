<?php
/*
命令模式

TIP1:
    1. 接收者（Receiver）负责执行与请求相关的操作

    2. 命令接口（Command）封装execute()、undo()等方法

    3. 具体命令（ConcreteCommand）实现命令接口中的方法

    4. 请求者（Invoker）包含Command接口变量
*/
interface CommandInterface
{
    /**
     * 在命令模式中这是最重要的方法,
     * Receiver在构造函数中传入.
     */
    public function execute();
}

/**
 * 这是一个调用Receiver的print方法的命令实现类，
 * 但是对于调用者而言，只知道调用命令类的execute方法
 */
class HelloCommand implements CommandInterface
{
    /**
     * @var Receiver
     */
    protected $output;

    /**
     * 每一个具体的命令基于不同的Receiver
     * 它们可以是一个、多个，甚至完全没有Receiver
     *
     * @param Receiver $console
     */
    public function __construct(Receiver $console)
    {
        $this->output = $console;
    }

    /**
     * 执行并输出 "Hello World"
     */
    public function execute()
    {
        // 没有Receiver的时候完全通过命令类来实现功能
        $this->output->write('Hello World');
    }
}


/**
 * Receiver类
 */
class Receiver
{
    /**
     * @param string $str
     */
    public function write($str)
    {
        echo $str;
    }
}

/**
 * Invoker类
 */
class Invoker
{
    /**
     * @var CommandInterface
     */
    protected $command;

    /**
     * 在调用者中我们通常可以找到这种订阅命令的方法
     *
     * @param CommandInterface $cmd
     */
    public function setCommand(CommandInterface $cmd)
    {
        $this->command = $cmd;
    }

    /**
     * 执行命令
     */
    public function run()
    {
        $this->command->execute();
    }
}


/**
 * CommandTest在命令模式中扮演客户端角色
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Invoker
     */
    protected $invoker;

    /**
     * @var Receiver
     */
    protected $receiver;

    protected function setUp()
    {
        $this->invoker = new Invoker();
        $this->receiver = new Receiver();
    }

    public function testInvocation()
    {
        $this->invoker->setCommand(new HelloCommand($this->receiver));
        $this->expectOutputString('Hello World');
        $this->invoker->run();
    }
}