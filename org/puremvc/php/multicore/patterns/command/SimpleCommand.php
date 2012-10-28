<?php
/**
 * PureMVC Multicore Port to PHP
 *
 * Partly based on PureMVC Port to PHP by:
 * - Omar Gonzalez <omar@almerblank.com>
 * - and Hasan Otuome <hasan@almerblank.com>
 *
 * Created on Jully 24, 2009
 *
 * @version 1.0
 * @author Michel Chouinard <michel.chouinard@gmail.com>
 * @copyright PureMVC - Copyright(c) 2006-2008 Futurescale, Inc., Some rights reserved.
 * @license http://creativecommons.org/licenses/by/3.0/ Creative Commons Attribution 3.0 Unported License
 * @package org.puremvc.php.multicore
 *
 */
/**
 *
 */

require_once 'org/puremvc/php/multicore/interfaces/ICommand.php';
require_once 'org/puremvc/php/multicore/interfaces/INotification.php';
require_once 'org/puremvc/php/multicore/interfaces/INotifier.php';
require_once 'org/puremvc/php/multicore/patterns/observer/Notifier.php';


/**
 * A base <b>ICommand</b> implementation.
 *
 * Your subclass should override the <b>execute</b>
 * method where your business logic will handle the <b>INotification</b>.
 *
 * @package org.puremvc.php.multicore
 * @see Controller
        org\puremvc\php\multicore\corev\Controller.php
 * @see Notification
        org\puremvc\php\multicore\patterns\observer\Notification.php
 * @see MacroCommand
        org.puremvc.php\multicore\patterns\command\MacroCommand.php
 */
class SimpleCommand extends Notifier implements ICommand, INotifier
{

    /**
     * Constructor.
     *
     * Your subclass MUST define a constructor, be
     * sure to call <b>parent::__construct();</b> to
     * have PHP instanciate the whole parent/child chain.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Fulfill the use-case initiated by the given <b>INotification</b>.
     *
     * In the Command Pattern, an application use-case typically
     * begins with some user action, which results in an <b>INotification</b> being broadcast, which
     * is handled by business logic in the <b>execute</b> method of an
     * <b>ICommand</b>.
     *
     * @param INotification $notification the <b>INotification</b> to handle.
     * @return void
     */
    public function execute( INotification $notification )
    {

    }

}
