<?php
    /*
    RosCMS - ReactOS Content Management System
    Copyright (C) 2005  Ge van Geldorp <gvg@reactos.org>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
    */


/**
 * class Login
 * 
 */
class Login
{
  const OPTIONAL = 1;
  const REQUIRED = 2;


  /**
   *
   *
   * @param string target to jump back after login process
   * @param string subsystem name which is called
   * @return int
   * @access public
   */
  public static function in( $login_type, $target, $subsys = '' )
  {
    global $roscms_intern_webserver_roscms;
    require_once(ROSCMS_PATH.'custom.php');
    $user_id = 0;

    if ( $login_type != self::OPTIONAL && $login_type != self::REQUIRED ){
      die('Invalid login_type '.$login_type.' for roscms_subsys_login');
    }

    // do update work, if a session is started
    if (isset($_COOKIE['roscmsusrkey']) && preg_match('/^([a-z]{32})$/', $_COOKIE['roscmsusrkey'], $matches)) {
      $session_id_clean = $matches[1];
      // get a valid ip
      if (isset($_SERVER['REMOTE_ADDR']) && preg_match('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/', $_SERVER['REMOTE_ADDR'], $matches) ) {
          $remote_addr_clean = $matches[1];
      }
      else{
          $remote_addr_clean = 'invalid';
      }

      // get user agent
      if (isset($_SERVER['HTTP_USER_AGENT'])) {
          $browser_agent_clean = $_SERVER['HTTP_USER_AGENT'];
      }
      else {
          $browser_agent_clean = 'unknown';
      }

      // Clean out expired sessions
      DBConnection::getInstance()->exec("DELETE FROM user_sessions WHERE usersession_expires IS NOT NULL AND usersession_expires < NOW()");

      // Now, see if we have a valid login session
      if ($subsys == '') {
        $stmt=DBConnection::getInstance()->prepare("SELECT u.user_id, s.usersession_expires AS session_expires FROM user_sessions s JOIN users u ON u.user_id = s.usersession_user_id WHERE s.usersession_id = :session_id AND (u.user_setting_ipaddress = 'false' OR s.usersession_ipaddress=:ip ) AND (u.user_setting_browseragent = 'false' OR s.usersession_browseragent = :agent) AND u.user_account_enabled = 'yes' LIMIT 1");
      }
      else{
        $stmt=DBConnection::getInstance()->prepare("SELECT m.map_subsys_userid AS user_id, s.usersession_expires AS session_expires FROM user_sessions s JOIN users u ON u.user_id = s.usersession_user_id JOIN subsys_mappings m ON m.map_roscms_userid = s.usersession_user_id WHERE s.usersession_id = :session_id AND (u.user_setting_ipaddress = 'false' OR s.usersession_ipaddress = :ip) AND (u.user_setting_browseragent = 'false' OR s.usersession_browseragent = :agent) AND m.map_subsys_name = :subsys AND u.user_account_enabled = 'yes' LIMIT 1");
          $stmt->bindParam('subsys',$subsys,PDO::PARAM_STR);
      }
      $stmt->bindParam('session_id',$session_id_clean,PDO::PARAM_INT);
      $stmt->bindParam('ip',$remote_addr_clean,PDO::PARAM_STR);
      $stmt->bindParam('agent',$browser_agent_clean,PDO::PARAM_STR);
      $stmt->execute() or die('DB error (user login) ');

      if ($row = $stmt->fetchOnce(PDO::FETCH_ASSOC)) {
        // Login session found
        $user_id = $row['user_id'];
        
        // Session with timeout. Update the expiry time in the table and the expiry time of the cookie
        if (isset($row['session_expires'])){
          $stmt=DBConnection::getInstance()->prepare("UPDATE user_sessions SET usersession_expires = DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE usersession_id = :session_id");
          $stmt->bindParam('session_id',$session_id_clean,PDO::PARAM_INT);
          $stmt->execute();
          setcookie('roscmsusrkey', $session_id_clean, time() + 30 * 60, '/', Cookie::getDomain());
        }
      }
    } // session check

    // goto login page, if login is required and no valid session was found
    if (0 == $user_id && $login_type == self::REQUIRED) {
      $url = $roscms_intern_webserver_roscms.'?page=login';
      if ($target != '') {
        $url .= '&target='.urlencode($target);
      }

      header('Location: '.$url);
      exit;
    }

    return $user_id;
  } // end of member function login


  /**
   *
   *
   * @param string target to jump back after login process
   * @param string subsystem name which is called
   * @return int
   * @access public
   */
  public static function out( $target = '' )
  {
    global $rdf_login_cookie_usrkey;
    global $roscms_SET_path_ex;

    if (isset($_COOKIE[$rdf_login_cookie_usrkey])) 
    {
      // delete cookie
      $del_session_id = $_COOKIE[$rdf_login_cookie_usrkey];
      setcookie($rdf_login_cookie_usrkey, '', time() - 3600, '/', Cookie::getDomain());

      // delete session from DB
      $stmt=DBConnection::getInstance()->prepare("DELETE FROM user_sessions WHERE usersession_id = :session_id");
      $stmt->bindparam('session_id',$del_session_id,PDO::PARAM_STR);
      $stmt->execute() or die('DB error (logout)!');

      // Set the Logout cookie for the Wiki, so the user won't see cached pages
      // 5 = $wgClockSkewFudge in the Wiki
      setcookie('wikiLoggedOut', gmdate('YmdHis', time() + 5), time() + 86400, '/', Cookie::getDomain());

    }

    if (isset($_REQUEST['target']) && $_REQUEST['target'] != '') {
      header('Location: http://'.$_SERVER['HTTP_HOST'].$_REQUEST['target']);
      exit;
    }

    header('Location: '.$roscms_SET_path_ex);
    exit;
  } // end of member function login

} // end of Login
?>
