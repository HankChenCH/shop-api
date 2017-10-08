<?php

namespace app\shop\command;  
  
use think\console\Command;
use think\console\Input;  
use think\console\Output;  
  
class Test extends Command  
{  
    protected function configure()  
    {  
        $this->setName('test')->setDescription('Command Test');  
    }  
  
    protected function execute(Input $input, Output $output)  
    {  
        $output->writeln("TestCommand:");  
    }  
}  