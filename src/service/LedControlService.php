<?php
namespace LedControl\Service;

class LedControlService
{
    /**
     * Activate LED via GPIO 
     * 
     * @param integer $pinNumber - GPIO pin number to be activated, 
     *                              see pin assignment from GPIO for more information
     * @return string|NULL
     */
    public function activateLed($pinNumber)
    {
        $command = 'gpio export ' . $pinNumber . ' out;';
        $command .= 'gpio -g write ' . $pinNumber . ' 1';
        
        return exec($command);
    }
    
    /**
     * Deactivate LED via GPIO
     * @param integer $pinNumber - GPIO pin number to be deactivated,
     *                              see pin assignment from GPIO for more information
     * @return string|NULL
     */
    public function deactivateLed($pinNumber)
    {
        $command = 'gpio export ' . $pinNumber . ' out;';
        $command .= 'gpio -g write ' . $pinNumber . ' 0';
        
        return exec($command);
    }
}
