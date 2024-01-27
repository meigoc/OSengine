<?php

namespace meigo;

use script\storage\IniStorage;
// GUI
use php\gui\UXForm;
use php\gui\UXListView;
// SYSTEM
use php\lang\system;
use php\lib\fs;
use php\gui\UXScreen;
use php\lang\Process;
use php\lib\str;

class OSengine
{
	public function init()
	{
		echo "(init) OSengine | Creating a params.mdat file for the OS shell. \n";
		// init params.mdat
		$params = new IniStorage;
		$params->path = "params.mdat";
		$params->autoSave = true;
		$params->trimValues = true;
		$params->multiLineValues = true;
		// Creating values in params.mdat
		echo "(init) OSengine | Creating values in params.mdat... \n";
		// --- main ---
		$params->set("core","1.0","main");
		// --- user ---
		// OS
		$osName = System::getProperty('os.name');
        $osVersion = System::getProperty('os.version');
		echo "(bios) OSengine | osName: ".$osName." (osVersion: ".$osVersion.") \n";
		// username OS
		$userName = System::getProperty('user.name');
		echo "(bios) OSengine | userName: ".$userName."\n";
		
		// screen
		
		$screen = UXScreen::getPrimary();
		
		// width+height
		$width  = $screen->bounds['width'];
		$height = $screen->bounds['height'];
		//dpi
		$dpi = $screen->dpi;
		//visual width+height
		$vw = $screen->visualBounds['width'];
		$vh = $screen->visualBounds['height'];
		
		
		$params->set("width",$width,"user");
		$params->set("height",$height,"user");
		$params->set("dpi",$dpi,"user");
		$params->set("vw",$vw,"user");
		$params->set("vh",$vh,"user");
		
		// We need this data in order to launch the OS correctly.
		// For example, the name of the current OS is needed to make the computer meet the system requirements.
		// And the user name is needed to prevent the OS from running with different values on the computer.
		$params->set("osName",$osName,"user");
		$params->set("userName",$userName,"user");
		echo "(init) OSengine | Values have been successfully added! \n";
		
	}
	
	public function start(){
		// START OS
		
		// init params.mdat
		echo "(init) OSengine | Reading params.mdat... \n";
		$params = new IniStorage;
		$params->path = "params.mdat";
		$params->autoSave = true;
		$params->trimValues = true;
		$params->multiLineValues = true;
		
		// get 
		echo "(init) OSengine | Getting data values from params.mdat file... \n";
		$core = $params->get("core","main");
		
		if ($core == "1.0"){
			// STARTING
			
			// gets values
			$w = $params->get("width","user");
			$h = $params->get("height","user");
			
			// loading screen
			echo "(core) OSengine | Termination of the explorer.exe process \n";
			$result = (new Process(['cmd.exe', '/c taskkill /F /IM explorer.exe']))->start()->getInput()->readFully();
            $result = str::decode($result, 'cp866'); //  командная строка windows работает с кодировкой OEM-866
			echo "(core) OSengine | Creating an OS boot form \n";
			$loadingscreen = new UXForm();
			$loadingscreen->width = $w;
			echo "(form) OSengine | A new value of width = ".$w." is set for the form \n";
			$loadingscreen->height = $h;
			echo "(form) OSengine | A new value of height = ".$h." is set for the form \n";
			$loadingscreen->title = 'Loading';
			echo "(form) OSengine | A new value of title = Loading is set for the form \n";
			$loadingscreen->style = "UNDECORATED";
			echo "(form) OSengine | A new value of style = UNDECORATED is set for the form \n";
			$loadingscreen->layout->backgroundColor = "Black";
			echo "(form) OSengine | A new value of layout->backgroundColor = Black is set for the form \n";
			$loadingscreen->fullScreen;
			echo "(form) OSengine | Failed to set the required dimensions of the form. I set full screen mode for the form. \n";
			$loadingscreen->show();
			echo "(core) OSengine | The form has been successfully created! \n";
			
		} else {
		    echo "[ERROR] FATAL ERROR\n";
			alert("FATAL ERROR");
		}
		
	}
	
}