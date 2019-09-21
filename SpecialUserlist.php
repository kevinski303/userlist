<?php

class SpecialUserlist extends SpecialPage {

    function __construct() {
        parent::__construct( 'Userlist' );
    }

    //Load list of users
    private function loadUsers() {
        return $this->loadFromFile();
    }
    
    //Save a list of users
    private function saveUsers( array $users ) {
        sort( $users );
        $this->saveToFile( $users );
    }

    // Helper function
    private function saveToFile( array $users ) {
        $file = fopen( "userlist.txt", "wb");
        $list = "";
        foreach ($users as $user) {
            $list = $list . "\r\n" . $user;
        }
        fwrite( $file, $list);
        fclose( $file );
    }

    // Helper function
    private function loadFromFile() {
        $file = fopen( "userlist.txt", "r" );
        $readfile = fread( $file, filesize( "userlist.txt" ));
        $userlist = array_filter(explode("\r\n", $readfile));
        fclose( $file );
        return $userlist;
    }
    
    /**
     * Called from mediawiki when we open the Special:Userlist page.
     */
    function execute($par) {
        global $wgRequest, $wgOut, $wgServer, $wgScriptPath, $wgUser;

        $this->setHeaders();

        # Get request data from, e.g.
        $param = $wgRequest->getText('param');
        
        $wgOut->setPageTitle("Userlist");
        $wgOut->addHTML('Lokale Benutzerrechte können hier vergeben werden.<br><br>');

        # Add scripts
        $wgOut->addHTML('<script src="' . $wgServer . $wgScriptPath . '/extensions/Userlist/userlist.js"></script>');
        
        # handle submitted form
        if ($this->handlePost()) {
            $wgOut->addHTML('<span id="success" style="color:#00AA33">Changes saved successfully!</span><script>$(document).ready(function() { $(\'#success\').fadeOut(5000); })</script><br>');
        }

        # Render Form
        $wgOut->addHTML('<form method="post"><input type="hidden" name="userlist" value="userlist">');

        $this->renderList($this->loadUsers(), "Userlist", "user");

        $wgOut->addHTML('<input type="submit" value="Save"></form>');
    }
    
    /**
     * Render a list of users/admins.
     */
    private function renderList(array $users, $title, $prefix) {
        global $wgOut;
        $wgOut->addHTML('<b>'.$title.':</b><div style="padding:0px;padding-left:10px"><div id="'.$prefix.'list">');
        foreach ($users as $user) {
            $wgOut->addHTML('<input type="checkbox" name="'.$prefix.'_'.$user.'" checked>'.$user.'<br>');
        }
        $wgOut->addHTML('</div><input type="text" id="'.$prefix.'name"> <input type="button" value="Add" onclick="add_'.$prefix.'()"></div><br>');
    }
    
    /**
     * Handle post request generated when the user clicked the save button.
     * 
     * @return boolean
     */
    private function handlePost() {
        # Did we submit the form?
        if (!isset($_POST['userlist'])) {
            return false;
        }
        
        # Get user and admin names
        $newUserlist = array();

        foreach ($_POST as $key => $value) {
            # Search for checked user_xxx inputs
            if ($value == 'on' && !empty($key) && strpos($key, 'user_') === 0) {
                array_push($newUserlist, substr($key, 5));
            }
        }
        
        # Save new lists
        $this->saveUsers($newUserlist);
        
        return true;
    }
}
