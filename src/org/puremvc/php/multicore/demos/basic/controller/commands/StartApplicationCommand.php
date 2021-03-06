<?php
namespace puremvc\php\multicore\demos\basic\controller\commands;
use puremvc\php\multicore\patterns\command\MacroCommand;
use puremvc\php\multicore\patterns\facade\Facade;


/**
 * PureMVC PHP Basic Demo
 * @author Omar Gonzalez :: omar@almerblank.com
 * @author Hasan Otuome :: hasan@almerblank.com
 *
 * Created on Sep 24, 2008
 * PureMVC - Copyright(c) 2006-2008 Futurescale, Inc., Some rights reserved.
 * Your reuse is governed by the Creative Commons Attribution 3.0 Unported License
 */

/**
 * The <code>StartApplicationCommand</code> prepares the view first
 * so that it is ready to display data when the model is done loading.
 */
class StartApplicationCommand extends MacroCommand
{
    protected $facade;

    public function __construct()
    {
        parent::__construct();
        $this->facade = Facade::getInstance('StartViewCommand');

    }
    /**
     * The <code>initializeMacroCommand</code> is overridden to
     * add references to instances of SimpleCommand that should
     * be executed.
     */
    protected function initializeMacroCommand()
    {
        $this->addSubCommand(StartViewCommand::class);
        $this->addSubCommand(StartModelCommand::class);
    }
}
