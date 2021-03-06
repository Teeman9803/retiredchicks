<?php

class WpdiscuzDBManager implements WpDiscuzConstants {

    private $db;
    private $dbprefix;
    private $users_voted;
    private $phrases;
    private $emailNotification;
    private $avatarsCache;
    public $isMySQL57;
    public $isShowLoadMore = false;

    function __construct() {
        $this->initDB();
    }

    private function initDB() {
        global $wpdb;
        $this->db = $wpdb;
        $this->dbprefix = $wpdb->prefix;
        $this->users_voted = $this->dbprefix . 'wc_users_voted';
        $this->phrases = $this->dbprefix . 'wc_phrases';
        $this->emailNotification = $this->dbprefix . 'wc_comments_subscription';
        $this->avatarsCache = $this->dbprefix . 'wc_avatars_cache';
        $this->isMySQL57 = version_compare($this->db->db_version(), '5.7', '>=') ? true : false;
    }

    /**
     * create table in db on activation if not exists
     */
    public function dbCreateTables() {
        $this->initDB();
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        if (!$this->isTableExists($this->users_voted)) {
            $sql = "CREATE TABLE `" . $this->users_voted . "`(`id` INT(11) NOT NULL AUTO_INCREMENT,`user_id` VARCHAR(255) NOT NULL, `comment_id` INT(11) NOT NULL, `vote_type` INT(11) DEFAULT NULL, `is_guest` TINYINT(1) DEFAULT 0, PRIMARY KEY (`id`), KEY `user_id` (`user_id`), KEY `comment_id` (`comment_id`),  KEY `vote_type` (`vote_type`), KEY `is_guest` (`is_guest`)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
            dbDelta($sql);
        }
        if (!$this->isTableExists($this->phrases)) {
            $sql = "CREATE TABLE `" . $this->phrases . "`(`id` INT(11) NOT NULL AUTO_INCREMENT, `phrase_key` VARCHAR(255) NOT NULL, `phrase_value` TEXT NOT NULL, PRIMARY KEY (`id`), KEY `phrase_key` (`phrase_key`)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
            dbDelta($sql);
        }

        if (!$this->isTableExists($this->avatarsCache)) {
            $sql = "CREATE TABLE `" . $this->avatarsCache . "`(`id` INT(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL DEFAULT 0, `user_email` VARCHAR(255) NOT NULL, `url` VARCHAR(255) NOT NULL, `hash` VARCHAR(255) NOT NULL, `maketime` INT(11) NOT NULL DEFAULT 0, `cached` TINYINT(1) NOT NULL DEFAULT 0, PRIMARY KEY (`id`), KEY `user_id` (`user_id`), UNIQUE KEY `user_email` (`user_email`), KEY `url` (`url`), KEY `hash` (`hash`), KEY `maketime` (`maketime`), KEY `cached` (`cached`)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
            dbDelta($sql);
        }
        $this->createEmailNotificationTable();
    }

    public function createAvatarsCacheTable() {
        $this->initDB();
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        if (!$this->isTableExists($this->avatarsCache)) {
            $sql = "CREATE TABLE `" . $this->avatarsCache . "`(`id` INT(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL DEFAULT 0, `user_email` VARCHAR(255) NOT NULL, `url` VARCHAR(255) NOT NULL, `hash` VARCHAR(255) NOT NULL, `maketime` INT(11) NOT NULL DEFAULT 0, `cached` TINYINT(1) NOT NULL DEFAULT 0, PRIMARY KEY (`id`), KEY `user_id` (`user_id`), UNIQUE KEY `user_email` (`user_email`), KEY `url` (`url`), KEY `hash` (`hash`), KEY `maketime` (`maketime`), KEY `cached` (`cached`)) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
            dbDelta($sql);
        }
    }

    /**
     * check if table exists in database
     * return true if exists false otherwise
     */
    public function isTableExists($tableName) {
        return $this->db->get_var("SHOW TABLES LIKE '$tableName'") == $tableName;
    }

    /**
     * creates subscription table if not exists 
     */
    public function createEmailNotificationTable() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $oldNotificationTableNameV200 = $this->dbprefix . 'wc_email_notfication';
        $oldNotificationTableNameV214 = $this->dbprefix . 'wc_email_notify';
        if (!$this->isTableExists($this->emailNotification)) {
            $sql = "CREATE TABLE `" . $this->emailNotification . "`(`id` INT(11) NOT NULL AUTO_INCREMENT, `email` VARCHAR(255) NOT NULL, `subscribtion_id` INT(11) NOT NULL, `post_id` INT(11) NOT NULL, `subscribtion_type` VARCHAR(255) NOT NULL, `activation_key` VARCHAR(255) NOT NULL, `confirm` TINYINT DEFAULT 0, `subscription_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `subscribtion_id` (`subscribtion_id`), KEY `post_id` (`post_id`), KEY `confirm`(`confirm`), UNIQUE KEY `subscribe_unique_index` (`subscribtion_id`,`email`)) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;";
            dbDelta($sql);
        }

        if ($this->isTableExists($oldNotificationTableNameV200)) {
            $this->saveNotificationDataV200($oldNotificationTableNameV200);
        }

        if ($this->isTableExists($oldNotificationTableNameV214)) {
            $this->saveNotificationDataV214($oldNotificationTableNameV214);
        }
    }

    /**
     * save old notification data from notification table v200 into new created table and drop old table
     */
    public function saveNotificationDataV200($oldNotificationTableName) {
        $sqlPostNotificationData = "SELECT * FROM `" . $oldNotificationTableName . "` WHERE `post_id` > 0;";
        $sqlCommentNotificationData = "SELECT * FROM `" . $oldNotificationTableName . "` WHERE `comment_id` > 0;";
        $postNotificationsData = $this->db->get_results($sqlPostNotificationData, ARRAY_A);
        $commentNotificationsData = $this->db->get_results($sqlCommentNotificationData, ARRAY_A);
        $insertedPostIds = array();
        foreach ($postNotificationsData as $pNotificationData) {
            $email = $pNotificationData['email'];
            $postId = $pNotificationData['post_id'];
            $insertedPostIds[] = $postId;
            $subscribtionType = "post";
            $activationKey = md5($email . uniqid() . time());
            $sqlAddOldPostNotification = "INSERT INTO `" . $this->emailNotification . "` (`email`, `subscribtion_id`, `post_id`, `subscribtion_type`, `activation_key`, `confirm`) VALUES('$email', $postId, $postId, '$subscribtionType', '$activationKey', '1');";
            $this->db->query($sqlAddOldPostNotification);
        }

        foreach ($commentNotificationsData as $cNotificationData) {
            $email = $cNotificationData['email'];
            $commentId = $cNotificationData['comment_id'];
            $comment = get_comment($commentId);
            if (!$this->wc_has_comment_notification($comment->comment_post_ID, $commentId, $email)) {
                $subscribtionType = "comment";
                $activationKey = md5($email . uniqid() . time());
                $sqlAddOldPostNotification = "INSERT INTO `" . $this->emailNotification . "` (`email`, `subscribtion_id`, `post_id`, `subscribtion_type`, `activation_key`, `confirm`) VALUES('$email', $commentId, $comment->comment_post_ID, '$subscribtionType', '$activationKey', '1');";
                $this->db->query($sqlAddOldPostNotification);
            }
        }

        $sqlDropOldNotificationTable = "DROP TABLE `" . $oldNotificationTableName . "`;";
        $this->db->query($sqlDropOldNotificationTable);
    }

    /**
     * save old notification data from notification table v214 into new created table and drop old table
     */
    public function saveNotificationDataV214($oldNotificationTableNameV214) {
        $sqlPostNotificationData = "INSERT INTO `" . $this->emailNotification . "` (`email`, `subscribtion_id`, `post_id`, `subscribtion_type`, `activation_key`, `confirm`) SELECT `email`, `subscribtion_id`, `post_id`, `subscribtion_type`, `activation_key`, '1' FROM " . $oldNotificationTableNameV214 . ";";
        $this->db->query($sqlPostNotificationData);
        $sqlDropOldNotificationTable = "DROP TABLE `" . $oldNotificationTableNameV214 . "`;";
        $this->db->query($sqlDropOldNotificationTable);
    }

    /**
     * add vote type
     */
    public function addVoteType($userId, $commentId, $voteType, $isUserLoggedIn) {
        $sql = $this->db->prepare("INSERT INTO `" . $this->users_voted . "`(`user_id`, `comment_id`, `vote_type`,`is_guest`)VALUES(%s,%d,%d,%d);", $userId, $commentId, $voteType, !$isUserLoggedIn);
        return $this->db->query($sql);
    }

    /**
     * update vote type
     */
    public function updateVoteType($user_id, $comment_id, $vote_type) {
        $sql = $this->db->prepare("UPDATE `" . $this->users_voted . "` SET `vote_type` = %d WHERE `user_id` = %s AND `comment_id` = %d", $vote_type, $user_id, $comment_id);
        return $this->db->query($sql);
    }

    /**
     * check if the user is already voted on comment or not by user id and comment id
     */
    public function isUserVoted($user_id, $comment_id) {
        $sql = $this->db->prepare("SELECT `vote_type` FROM `" . $this->users_voted . "` WHERE `user_id` = %s AND `comment_id` = %d;", $user_id, $comment_id);
        return $this->db->get_var($sql);
    }

    /**
     * update phrases
     */
    public function updatePhrases($phrases) {
        if ($phrases) {
            foreach ($phrases as $phrase_key => $phrase_value) {

                if (is_array($phrase_value) && array_key_exists(WpdiscuzHelper::$datetime, $phrase_value)) {
                    $phrase_value = $phrase_value[WpdiscuzHelper::$datetime][0];
                }
                if ($this->isPhraseExists($phrase_key)) {
                    $sql = $this->db->prepare("UPDATE `" . $this->phrases . "` SET `phrase_value` = %s WHERE `phrase_key` = %s;", str_replace('"', '&#34;', $phrase_value), $phrase_key);
                } else {
                    $sql = $this->db->prepare("INSERT INTO `" . $this->phrases . "`(`phrase_key`, `phrase_value`)VALUES(%s, %s);", $phrase_key, str_replace('"', '&#34;', $phrase_value));
                }
                $this->db->query($sql);
            }
        }
    }

    /**
     * checks if the phrase key exists in database
     */
    public function isPhraseExists($phrase_key) {
        $sql = $this->db->prepare("SELECT `phrase_key` FROM `" . $this->phrases . "` WHERE `phrase_key` LIKE %s", $phrase_key);
        return $this->db->get_var($sql);
    }

    /**
     * get phrases from db
     */
    public function getPhrases() {
        $sql = "SELECT `phrase_key`, `phrase_value` FROM `" . $this->phrases . "`;";
        $phrases = $this->db->get_results($sql, ARRAY_A);
        $tmp_phrases = array();
        foreach ($phrases as $phrase) {
            $tmp_phrases[$phrase['phrase_key']] = WpdiscuzHelper::initPhraseKeyValue($phrase);
        }
        return $tmp_phrases;
    }

    /**
     * get last comment id from database
     * current post last comment id if post id was passed
     */
    public function getLastCommentId($args) {
        if ($args['post_id']) {
            $approved = '';
            if ($args['status'] != 'all') {
                $approved = " AND `comment_approved` = '1' ";
            }
            $sql = $this->db->prepare("SELECT MAX(`comment_ID`) FROM `" . $this->dbprefix . "comments` WHERE `comment_post_ID` = %d " . $approved . ";", $args['post_id']);
        } else {
            $sql = "SELECT MAX(`comment_ID`) FROM `" . $this->dbprefix . "comments`;";
        }
        return $this->db->get_var($sql);
    }

    /**
     * retrives new comment ids for live update (UA - Update Automatically)
     */
    public function getNewCommentIds($args, $loadLastCommentId, $email) {
        $approved = '';
        if ($args['status'] != 'all') {
            $approved = " AND `comment_approved` = '1' ";
        }
        $sqlCommentIds = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_post_ID` = %d AND `comment_ID` > %d AND `comment_author_email` != %s " . $approved . " ORDER BY `comment_date_gmt` ASC;", $args['post_id'], $loadLastCommentId, $email);
        return $this->db->get_col($sqlCommentIds);
    }

    /**
     * @param type $visibleCommentIds comment ids which is visible at the moment on front end
     * @param type $email the current user email
     * @return type array of author comment ids
     */
    public function getAuthorVisibleComments($args, $visibleCommentIds, $email) {
        $sql = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_approved` = '1' AND `comment_ID` IN($visibleCommentIds) AND `comment_author_email` = %s;", $email);
        return $this->db->get_col($sql);
    }

    /**
     * get current post  parent comments by wordpress settings
     */
    public function getPostParentComments($args) {
        $commentParent = $args['is_threaded'] ? 'AND `comment_parent` = 0' : '';
        $condition = $this->getParentCommentsClauses($args);
        $limit = "";
        if (!$this->isMySQL57) {
            $limit = " LIMIT " . ($args['limit'] + 1);
        }
        if ($args['limit'] == 0) {
            $allParentCounts = count($this->getAllParentCommentCount($args['post_id'], $args['is_threaded']));
            $sqlComments = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_post_ID` = %d  $condition $commentParent ORDER BY `comment_date_gmt` {$args['order']} LIMIT %d OFFSET %d", $args['post_id'], $allParentCounts, $args['offset']);
        } else if ($args['last_parent_id']) {
            $operator = ($args['order'] == 'asc') ? '>' : '<';
            $sqlComments = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_post_ID` = %d  $condition $commentParent AND `comment_ID` $operator %d ORDER BY `comment_date_gmt` {$args['order']}, comment_ID {$args['order']} $limit", $args['post_id'], $args['last_parent_id']);
        } else {
            $sqlComments = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_post_ID` = %d  $condition $commentParent ORDER BY `comment_date_gmt` {$args['order']}, comment_ID {$args['order']} $limit", $args['post_id']);
        }
        $data = $this->db->get_col($sqlComments);
        if (isset($args['limit']) && $args['limit'] != 0) {
            if ($this->isMySQL57) {
                $data = array_slice($data, 0, $args['limit'] + 1);
            }
            if (count($data) > $args['limit']) {
                $data = array_slice($data, 0, $args['limit']);
                $this->isShowLoadMore = true;
            }
        }
        return $data;
    }

    /**
     * get comment list ordered by date or comments votes
     */
    public function getCommentList($args) {
        if ($args['orderby'] == 'by_vote') {
            $parentIds = $this->getPostVotedCommentIds($args);
        } else {
            $parentIds = $this->getPostParentComments($args);
        }
        return $parentIds;
    }

    /**
     * get post most voted comments
     * @param type $args['post_id'] the current post id
     * @param type $args['order'] data ordering asc / desc
     * @param type $args['limit'] how many rows select
     * @param type $args['offset'] rows offset
     * @return type array of comments
     */
    public function getPostVotedCommentIds($args) {
        $commentParent = $args['is_threaded'] ? 'AND `c`.`comment_parent` = 0' : '';
        $condition = $this->getParentCommentsClauses($args, '`c`.');
        if ($args['limit']) {
            $sqlPostVotedCommentIds = $this->db->prepare("SELECT `c`.`comment_ID` FROM `" . $this->dbprefix . "comments` AS `c` LEFT JOIN `" . $this->dbprefix . "commentmeta` AS `cm` ON `c`.`comment_ID` = `cm`.`comment_id` AND `cm`.`meta_key` = '" . self::META_KEY_VOTES . "'  WHERE  `c`.`comment_post_ID` = %d  $condition $commentParent ORDER BY (`cm`.`meta_value`+0) desc, `c`.`comment_date_gmt` {$args['date_order']} LIMIT %d OFFSET %d", $args['post_id'], $args['limit'] + 1, $args['offset']);
        } else {
            $allParentCounts = count($this->getAllParentCommentCount($args['post_id'], $args['is_threaded']));
            $sqlPostVotedCommentIds = $this->db->prepare("SELECT `c`.`comment_ID` FROM `" . $this->dbprefix . "comments` AS `c` LEFT JOIN `" . $this->dbprefix . "commentmeta` AS `cm` ON `c`.`comment_ID` = `cm`.`comment_id` AND `cm`.`meta_key` = '" . self::META_KEY_VOTES . "'  WHERE  `c`.`comment_post_ID` = %d  $condition $commentParent ORDER BY (`cm`.`meta_value`+0) desc, `c`.`comment_date_gmt` {$args['date_order']} LIMIT %d OFFSET %d", $args['post_id'], $allParentCounts, $args['offset']);
        }
        $data = $this->db->get_col($sqlPostVotedCommentIds);
        if (isset($args['limit']) && $args['limit'] != 0 && count($data) > $args['limit']) {
            $data = array_slice($data, 0, $args['limit']);
            $this->isShowLoadMore = true;
        }
        return $data;
    }

    public function getAllParentCommentCount($postId = 0, $isThreaded = 1) {
        $commentParent = $isThreaded ? '`comment_parent` = 0' : '1';
        if ($postId) {
            $sql_comments = $this->db->prepare("SELECT `comment_ID` FROM  `" . $this->dbprefix . "comments` WHERE $commentParent AND `comment_post_ID` = %d AND `comment_approved` = '1'", $postId);
        } else {
            $sql_comments = "SELECT `comment_ID` FROM  `" . $this->dbprefix . "comments` WHERE $commentParent";
        }
        return $this->db->get_col($sql_comments);
    }

    /**
     * get first level comments by parent comment id
     */
    public function getCommentsByParentId($commentId) {
        $sql_comments = $this->db->prepare("SELECT `comment_ID` FROM `" . $this->dbprefix . "comments` WHERE `comment_parent` = %d AND `comment_approved` = '1';", $commentId);
        return $this->db->get_col($sql_comments);
    }

    public function addEmailNotification($subsriptionId, $postId, $email, $subscriptionType, $confirm = 0) {
        if ($subscriptionType != self::SUBSCRIPTION_COMMENT) {
            $this->deleteCommentNotifications($subsriptionId, $email);
        }
        $activationKey = md5($email . uniqid() . time());
        $sql = $this->db->prepare("INSERT INTO `" . $this->emailNotification . "` (`email`, `subscribtion_id`, `post_id`, `subscribtion_type`, `activation_key`,`confirm`) VALUES(%s, %d, %d, %s, %s, %d);", $email, $subsriptionId, $postId, $subscriptionType, $activationKey, $confirm);
        $this->db->query($sql);
        return $this->db->insert_id ? array('id' => $this->db->insert_id, 'activation_key' => $activationKey) : false;
    }

    public function getPostNewCommentNotification($post_id, $email) {
        $sql = $this->db->prepare("SELECT `id`, `email`, `activation_key` FROM `" . $this->emailNotification . "` WHERE `subscribtion_type` = %s AND `confirm` = 1 AND `post_id` = %d  AND `email` != %s;", self::SUBSCRIPTION_POST, $post_id, $email);
        return $this->db->get_results($sql, ARRAY_A);
    }

    public function getAllNewCommentNotification($post_id, $email) {
        $sql = $this->db->prepare("SELECT `id`, `email`, `activation_key` FROM `" . $this->emailNotification . "` WHERE `subscribtion_type` = %s AND `confirm` = 1 AND `post_id` = %d  AND `email` != %s;", self::SUBSCRIPTION_ALL_COMMENT, $post_id, $email);
        return $this->db->get_results($sql, ARRAY_A);
    }

    public function getNewReplyNotification($comment_id, $email) {
        $sql = $this->db->prepare("SELECT `id`, `email`, `activation_key` FROM `" . $this->emailNotification . "` WHERE `subscribtion_type` = %s AND `confirm` = 1 AND `subscribtion_id` = %d  AND `email` != %s;", self::SUBSCRIPTION_COMMENT, $comment_id, $email);
        return $this->db->get_results($sql, ARRAY_A);
    }

    public function hasSubscription($postId, $email) {
        $sql = $this->db->prepare("SELECT `subscribtion_type` as `type`, `confirm` FROM `" . $this->emailNotification . "` WHERE  `post_id` = %d AND `email` = %s;", $postId, $email);
        $result = $this->db->get_row($sql, ARRAY_A);
        return $result;
    }

    public function hasConfirmedSubscription($email) {
        $sql = "SELECT `subscribtion_type` as `type` FROM `" . $this->emailNotification . "` WHERE `email` = %s AND `confirm` = 1;";
        $sql = $this->db->prepare($sql, $email);
        return $this->db->get_var($sql);
    }

    public function hasConfirmedSubscriptionByID($subscribID) {
        $sql = "SELECT `subscribtion_type` as `type` FROM `" . $this->emailNotification . "` WHERE `id` = %d AND `confirm` = 1;";
        $sql = $this->db->prepare($sql, $subscribID);
        return $this->db->get_var($sql);
    }

    /**
     * delete comment thread subscriptions if new subscription type is post
     */
    public function deleteCommentNotifications($post_id, $email) {
        $sql_delete_comment_notifications = $this->db->prepare("DELETE FROM `" . $this->emailNotification . "` WHERE `subscribtion_type` != %s AND `post_id` = %d AND `email` LIKE %s;", self::SUBSCRIPTION_POST, $post_id, $email);
        $this->db->query($sql_delete_comment_notifications);
    }

    /**
     * create unsubscribe link
     */
    public function unsubscribeLink($postID, $email) {
        global $wp_rewrite;
        $sql_subscriber_data = $this->db->prepare("SELECT `id`, `post_id`, `activation_key` FROM `" . $this->emailNotification . "` WHERE  `post_id` = %d  AND `email` LIKE %s", $postID, $email);
        $wc_unsubscribe = $this->db->get_row($sql_subscriber_data, ARRAY_A);
        $post_id = $wc_unsubscribe['post_id'];
        $wc_unsubscribe_link = !$wp_rewrite->using_permalinks() ? get_permalink($post_id) . "&" : get_permalink($post_id) . "?";
        $wc_unsubscribe_link .= "subscribeAnchor&wpdiscuzSubscribeID=" . $wc_unsubscribe['id'] . "&key=" . $wc_unsubscribe['activation_key'] . '&#wc_unsubscribe_message';
        return $wc_unsubscribe_link;
    }

    /**
     * generate confirm link
     */
    public function confirmLink($id, $activationKey, $postID) {
        global $wp_rewrite;
        $wc_confirm_link = !$wp_rewrite->using_permalinks() ? get_permalink($postID) . "&" : get_permalink($postID) . "?";
        $wc_confirm_link .= "subscribeAnchor&wpdiscuzConfirmID=$id&wpdiscuzConfirmKey=$activationKey&wpDiscuzComfirm=yes&#wc_unsubscribe_message";
        return $wc_confirm_link;
    }

    /**
     * Confirm  post or comment subscription
     */
    public function notificationConfirm($subscribe_id, $key) {
        $sql_confirm = $this->db->prepare("UPDATE `" . $this->emailNotification . "` SET `confirm` = 1 WHERE `id` = %d AND `activation_key` LIKE %s;", $subscribe_id, $key);
        return $this->db->query($sql_confirm);
    }

    /**
     * delete subscription
     */
    public function unsubscribe($id, $activation_key) {
        $sql_unsubscribe = $this->db->prepare("DELETE FROM `" . $this->emailNotification . "` WHERE `id` = %d AND `activation_key` LIKE %s", $id, $activation_key);
        return $this->db->query($sql_unsubscribe);
    }

    public function alterPhrasesTable() {
        $sql_alter = "ALTER TABLE `" . $this->phrases . "` MODIFY `phrase_value` TEXT NOT NULL;";
        $this->db->query($sql_alter);
    }

    public function alterVotingTable() {
        $sql_alter = "ALTER TABLE `" . $this->users_voted . "` MODIFY `user_id` VARCHAR(255) NOT NULL, ADD COLUMN `is_guest` TINYINT(1) DEFAULT 0, ADD INDEX `is_guest` (`is_guest`);";
        $this->db->query($sql_alter);
    }

    public function alterNotificationTable() {
        $sql_alter = "ALTER TABLE `" . $this->emailNotification . "` ADD UNIQUE KEY `subscribe_unique_index` (`subscribtion_id`,`email`);";
        $this->db->query($sql_alter);
    }

    /**
     * return users id who have published posts
     */
    public function getPostsAuthors() {
        if (($postsAuthors = get_transient(self::TRS_POSTS_AUTHORS)) === false) {
            $sql = "SELECT `post_author` FROM `" . $this->dbprefix . "posts` WHERE `post_type` = 'post' AND `post_status` IN ('publish', 'private') GROUP BY `post_author`;";
            $postsAuthors = $this->db->get_col($sql);
            set_transient(self::TRS_POSTS_AUTHORS, $postsAuthors, 6 * HOUR_IN_SECONDS);
        }
        return $postsAuthors;
    }

    public function removeVotes() {
        $sqlTruncate = "TRUNCATE `" . $this->dbprefix . "wc_users_voted`;";
        $sqlDelete = "DELETE FROM `" . $this->dbprefix . "commentmeta` WHERE `meta_key` = '" . self::META_KEY_VOTES . "';";
        return $this->db->query($sqlTruncate) && $this->db->query($sqlDelete);
    }

    private function getParentCommentsClauses($args, $alias = '') {
        $s = ' AND ';
        $status = $args['status'];
        if ($status == 'all') {
            $s .= "($alias`comment_approved` = '0' OR $alias`comment_approved` = '1')";
        } else if ($status == 'hold') {
            $s .= "($alias`comment_approved` = '0')";
        } else {
            $condition = ' ';
            if (isset($args['include_unapproved']) && is_int($args['include_unapproved'][0])) {
                $condition .= " OR ($alias`comment_approved` = '0' AND $alias`user_id` = {$args['include_unapproved'][0] })";
            } elseif (isset($args['include_unapproved']) && $args['include_unapproved'][0]) {
                $condition .= " OR ($alias`comment_approved` = '0' AND $alias`comment_author_email` = '{$args['include_unapproved'][0]}')";
            }
            $s .= "($alias`comment_approved` = '1' $condition )";
        }
        return apply_filters('wpdiscuz_parent_comments_clauses', $s);
    }

    public function getVotes($commentId) {
        $sql = "SELECT IFNULL(SUM(`vote_type`), 0) FROM `" . $this->users_voted . "` WHERE `vote_type` = 1 AND `comment_id` = %d UNION SELECT IFNULL(SUM(`vote_type`), 0) FROM `" . $this->users_voted . "` WHERE `vote_type` = -1 AND `comment_id` = %d";
        $sql = $this->db->prepare($sql, $commentId, $commentId);
        return $this->db->get_col($sql);
    }

    public function getLikeCount($commentId) {
        $sql = "SELECT IFNULL(SUM(`vote_type`), 0) FROM `" . $this->users_voted . "` WHERE `vote_type` = 1 AND `comment_id` = %d ";
        $sql = $this->db->prepare($sql, $commentId);
        return $this->db->get_var($sql);
    }

    public function getDislikeCount($commentId) {
        $sql = "SELECT IFNULL(SUM(`vote_type`), 0) FROM `" . $this->users_voted . "` WHERE `vote_type` = -1 AND `comment_id` = %d";
        $sql = $this->db->prepare($sql, $commentId);
        return $this->db->get_var($sql);
    }

    public function importOptions($serializedOptions) {
        if ($serializedOptions) {
            $serializedOptions = stripslashes($serializedOptions);
            $sql = "UPDATE `" . $this->dbprefix . "options` SET `option_value` = %s WHERE `option_name` = '" . self::OPTION_SLUG_OPTIONS . "'";
            $sql = $this->db->prepare($sql, $serializedOptions);
            $this->db->query($sql);
        }
    }

    /* MULTI SITE */

    public function getBlogID() {
        return $this->db->blogid;
    }

    public function getBlogIDs() {
        return $this->db->get_col("SELECT blog_id FROM {$this->db->blogs}");
    }

    public function dropTables() {
        $this->initDB();
        $this->db->query("DROP TABLE IF EXISTS `{$this->emailNotification}`");
        $this->db->query("DROP TABLE IF EXISTS `{$this->phrases}`");
        $this->db->query("DROP TABLE IF EXISTS `{$this->users_voted}`");
        $this->db->query("DROP TABLE IF EXISTS `{$this->avatarsCache}`");
    }

    public function deleteSubscriptions($commnetId) {
        if ($cId = intval($commnetId)) {
            $sql = $this->db->prepare("DELETE FROM `{$this->emailNotification}` WHERE `subscribtion_id` = %d;", $cId);
            $this->db->query($sql);
        }
    }

    public function deleteVotes($commnetId) {
        if ($cId = intval($commnetId)) {
            $sql = $this->db->prepare("DELETE FROM `{$this->users_voted}` WHERE `comment_id` = %d;", $cId);
            $this->db->query($sql);
        }
    }

    /* === GRAVATARS CACHE === */

    public function addGravatars($gravatarsData) {
        if ($gravatarsData && is_array($gravatarsData)) {
            $sql = "INSERT INTO `{$this->avatarsCache}`(`user_id`, `user_email`, `url`, `hash`, `maketime`, `cached`) VALUES";
            $sqlValues = '';
            $makeTime = current_time('timestamp');
            foreach ($gravatarsData as $gravatarData) {
                $userId = intval($gravatarData['user_id']);
                $userEmail = esc_sql($gravatarData['user_email']);
                $url = esc_url($gravatarData['url']);
                $hash = esc_attr($gravatarData['hash']);
                $cached = intval($gravatarData['cached']);
                $sqlValues .= "($userId, '$userEmail', '$url', '$hash', '$makeTime', $cached),";
            }
            $sql .= rtrim($sqlValues, ',');
            $sql .= "ON DUPLICATE KEY UPDATE `user_id` = `user_id`, `user_email` = `user_email`, `url` = `url`, `hash` = `hash`, `maketime` = `maketime`, `cached` = `cached`;";
            $this->db->query($sql);
        }
    }

    public function getGravatars($limit = 10) {
        $data = array();
        $limit = apply_filters('wpdiscuz_gravatars_cache_limit', $limit);
        if ($l = intval($limit)) {
            $sql = $this->db->prepare("SELECT * FROM `{$this->avatarsCache}` WHERE `cached` = 0 LIMIT %d;", $l);
            $data = $this->db->get_results($sql, ARRAY_A);
        }
        return $data;
    }

    public function getExpiredGravatars($timeFrame) {
        $data = array();
        if ($timeFrame) {
            $currentTime = current_time('timestamp');
            $sql = $this->db->prepare("SELECT CONCAT(`hash`, '.gif') FROM `{$this->avatarsCache}` WHERE `maketime` + %d < %d", $timeFrame, $currentTime);
            $data = $this->db->get_col($sql);
        }
        return $data;
    }

    public function deleteExpiredGravatars($timeFrame) {
        if ($timeFrame) {
            $currentTime = current_time('timestamp');
            $sql = $this->db->prepare("DELETE FROM `{$this->avatarsCache}` WHERE `maketime` + %d < %d;", $timeFrame, $currentTime);
            $this->db->query($sql);
        }
    }

    public function deleteGravatars() {
        $this->db->query("TRUNCATE `{$this->avatarsCache}`;");
    }

    public function updateGravatarsStatus($cachedIds) {
        if ($cachedIds) {
            $makeTime = current_time('timestamp');
            $ids = implode(',', $cachedIds);
            $sql = "UPDATE `{$this->avatarsCache}` SET `maketime` = $makeTime, `cached` = 1 WHERE `id` IN ($ids);";
            $this->db->query($sql);
        }
    }

    /* === GRAVATARS CACHE === */
}
