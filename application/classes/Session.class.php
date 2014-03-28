<?php
/**
 * PHP session handling with MySQL-DB
 *
 * @package MYSYSTEM
 * @since 20110608 11:06
 */

/**
 * Session
 *
 * @package MYSYSTEM
 * @since 20110608 11:06
 */
class Session {

    protected static $db     = null;
    private static $lifetime = 0;
    private static $id       = 0;

    /**
     * Create a new session (or get the existing one)
     *
     * @param Database
     * @return void
     */
    public function __construct($db) {
        self::$db = $db;

        session_set_save_handler(
            array(&$this, 'open'),
            array(&$this, 'close'),
            array(&$this, 'read'),
            array(&$this, 'write'),
            array(&$this, 'destroy'),
            array(&$this, 'gc'));
        register_shutdown_function('session_write_close');

        if ( !session_id() ) {
            session_cache_limiter('none');
            session_start();
        }

        self::$id = session_id();
    }

    /**
     * Get ID
     *
     * @return int
     */
    public static function getID() {
        return self::$id;
    }

    /**
     * Open the session
     *
     * @return boolean
     */
    public static function open() {
        self::$lifetime = ini_get('session.gc_maxlifetime');
        return true;
    }
    /**
     * Close the session
     * (will be executed when end of the whole site is reached)
     *
     * @return void
     */
    public static function close() {
    }

    /**
     * Read the session
     *
     * @param int session id
     * @return string string of the sessoin
     */
    public static function read($id) {
        $sql = sprintf("SELECT `session_data` FROM `".Conf::$DB_PREFIX."core_session` " .
                            "WHERE `session_id` = '%s'", $id);
        $rows = self::$db->loadResult($sql);
        if (  $rows ) {
            $row = array_shift($rows);
            return $row->session_data;
        }
        return '';
    }

    /**
     * Write the session
     *
     * @param int session id
     * @param string data of the session
     * return boolean
     */
    public static function write($id, $data) {
        $sql = sprintf("INSERT INTO `".Conf::$DB_PREFIX."core_session` SET
                        session_id='%s', 
                        session_started=NOW(),
                        session_expires=UNIX_TIMESTAMP(ADDDATE(NOW(), interval 1 hour)), 
                        session_data='%s'
                        ON DUPLICATE KEY UPDATE session_data='%s', session_expires=UNIX_TIMESTAMP(ADDDATE(NOW(), interval 1 hour))",
                        ($id),
                        ($data),
                        ($data)
                    );
        $result = self::$db->query($sql);
        return session_id();
    }

    /**
     * Destroy the session
     *
     * @param int session id
     * @return boolean
     */
    public static function destroy($id) {
        $sql = sprintf("DELETE FROM `".Conf::$DB_PREFIX."core_session` WHERE `session_id` = '%s'", $id);
        return self::$db->query($sql);
    }

    /**
     * Garbage Collector
     *
     * @param int life time (sec.)
     * @return boolean
     * @see session.gc_divisor      100
     * @see session.gc_maxlifetime 1440
     * @see session.gc_probability    1
     */
    public static function gc($max) {
        $sql = sprintf("DELETE FROM `".Conf::$DB_PREFIX."core_session` WHERE `session_expires` < '%s'",
            (time() - $max)
        );
        return self::$db->query($sql);
    }
}
?>