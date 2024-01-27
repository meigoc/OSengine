<?php
namespace meigo\forms;

use system\DFFIReferenceValue;
use system\DFFIStruct;
use system\DFFIType;
use system\DFFI;
use std, gui, framework, meigo;
use meigo\OSengine;


class MainForm extends AbstractForm
{

    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {    
        (new OSengine->init());
    }

    /**
     * @event buttonAlt.action 
     */
    function doButtonAltAction(UXEvent $e = null)
    {    
        (new OSengine->start());
    }

    /**
     * @event button3.action 
     */
    function doButton3Action(UXEvent $e = null)
    {    
        $this->layout->free();
    }

    /**
     * @event button4.action 
     */
    function doButton4Action(UXEvent $e = null)
    {    
        execute('explorer.exe');
    }

    /**
     * @event button5.action 
     */
    function doButton5Action(UXEvent $e = null)
    {    
       
    }

}
