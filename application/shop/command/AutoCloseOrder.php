<?php

namespace app\shop\command;

use think\console\Command;
use think\console\Input;  
use think\console\Output;
use app\api\model\Order as OrderModel; 
use app\lib\enum\OrderStatusEnum;

class AutoCloseOrder extends Command  
{  
    protected function configure()  
    {  
    	$time = config('setting.order_close_time');
        $this->setName('autoCloseOrder')->setDescription("Auto close order before {$time} min ago");  
    }  
  
    protected function execute(Input $input, Output $output)  
    {  
    	$output->writeln("ready");

    	$now = time();
    	$time = config('setting.order_close_time');
    	$minAgo = $now - ($time * 60);

    	$output->writeln("begin"); 

    	$orders = OrderModel::where('create_time', 'ELT', $minAgo)
    					->where('status', 'EQ', OrderStatusEnum::UNPAID)
    					->update(['status' => OrderStatusEnum::CLOSED]);

        $output->writeln("commplent");  
    }  
}  