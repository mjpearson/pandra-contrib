<?php
/**
 * PandraLoggerFirePHP
 *
 * FirePHP implementation of PandraLogger.  Handles all priority levels
 * Requires the FirePHP classes be included prior to call
 *
 * @author Michael Pearson <pandra-support@phpgrease.net>
 * @copyright 2010 phpgrease.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version 0.2
 * @package pandra
 */
class PandraLoggerFirePHP implements PandraLogger {

    private $_isOpen = FALSE;

    private $_fb = NULL;

    public function __construct(array $params) {
        $this->_isOpen = class_exists('FB');
        if ($this->_isOpen) {
            $this->_fb = FirePHP::getInstance(true);
        }
        return $this->_isOpen;
    }

    public function isOpen() {
        return $this->_isOpen;
    }

    /**
     * FirePHP will log for anything
     * @param int $priority requested priority log
     * @return boolean this logger will log for priority
     */
    public function isPriorityLogger($priority) {
        return TRUE;
    }

    public function execute($priority, $message) {
        if ($this->isPriorityLogger($priority) && $this->_isOpen) {
            switch ($priority) {
                case PandraLog::LOG_NOTICE :
                    $this->_fb->log($message);
                    break;
                case PandraLog::LOG_DEBUG :
                case PandraLog::LOG_INFO :
                    $this->_fb->info($message);
                    break;
                case PandraLog::LOG_WARNING :
                    $this->_fb->warn($message);
                    break;
                default:
                    $this->_fb->error($message);
                    break;
            }
            return TRUE;
        }
        return FALSE;
    }
}
?>