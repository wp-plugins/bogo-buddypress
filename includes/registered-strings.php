<?php

function bogobud_registered_strings() {

	return array(

// bp-activity-notifications.php, mail 1, subject
'%s mentioned you in an update',

// bp-activity-notifications.php, mail 1, message part 1, option 1
'%1$s mentioned you in the group "%2$s":

"%3$s"

To view and respond to the message, log in and visit: %4$s

---------------------
',

// bp-activity-notifications.php, mail 1, message part 1, option 2
'%1$s mentioned you in an update:

"%2$s"

To view and respond to the message, log in and visit: %3$s

---------------------
',

// bp-activity-notifications.php, mail 1, message part 2
'To disable these notifications please log in and go to: %s',

// bp-activity-notifications.php, mail 2, subject
'%s replied to one of your updates',

// bp-activity-notifications.php, mail 2, message part 1
'%1$s replied to one of your updates:

"%2$s"

To view your original update and all comments, log in and visit: %3$s

---------------------
',

// bp-activity-notifications.php, mail 2, message part 2
'To disable these notifications please log in and go to: %s',

// bp-activity-notifications.php, mail 3, subject
'%s replied to one of your comments',

// bp-activity-notifications.php, mail 3, message part 1
'%1$s replied to one of your comments:

"%2$s"

To view the original activity, your comment and all replies, log in and visit: %3$s

---------------------
',

// bp-activity-notifications.php, mail 3, message part 2
'To disable these notifications please log in and go to: %s',

// bp-core-filters.php, mail 1, subject
'Activate %s',

// bp-core-filters.php, mail 1, message
"%1\$s,\n\n\n\nThanks for registering! To complete the activation of your account and blog, please click the following link:\n\n%2\$s\n\n\n\nAfter you activate, you can visit your blog here:\n\n%3\$s",

// bp-core-filters.php, mail 2, subject
'Activate Your Account',

// bp-core-filters.php, mail 2, message
"Thanks for registering! To complete the activation of your account please click the following link:\n\n%1\$s\n\n",

// bp-friends-notifications.php, mail 1, subject
'New friendship request from %s',

// bp-friends-notifications.php, mail 1, message part 1
'%1$s wants to add you as a friend.

To view all of your pending friendship requests: %2$s

To view %3$s\'s profile: %4$s

---------------------
',

// bp-friends-notifications.php, mail 1, message part 2
'To disable these notifications please log in and go to: %s',

// bp-friends-notifications.php, mail 2, subject
'%s accepted your friendship request',

// bp-friends-notifications.php, mail 2, message part 1
'%1$s accepted your friend request.

To view %2$s\'s profile: %3$s

---------------------
',

// bp-friends-notifications.php, mail 2, message part 2
'To disable these notifications please log in and go to: %s',

// bp-groups-notifications.php, mail 1, subject
'Group Details Updated',

// bp-groups-notifications.php, mail 1, message part 1
'Group details for the group "%1$s" were updated: %2$s

To view the group: %3$s

---------------------
',

// bp-groups-notifications.php, mail 1, message part 2
'To disable these notifications please log in and go to: %s',

// bp-groups-notifications.php, mail 2, subject
'Membership request for group: %s',

// bp-groups-notifications.php, mail 2, message part 1, option 1
'%1$s wants to join the group "%2$s".

Message from %1$s: "%3$s"

Because you are the administrator of this group, you must either accept or reject the membership request.

To view all pending membership requests for this group, please visit:
%4$s

To view %5$s\'s profile: %6$s

---------------------
',

// bp-groups-notifications.php, mail 2, message part 1, option 2
'%1$s wants to join the group "%2$s".

Because you are the administrator of this group, you must either accept or reject the membership request.

To view all pending membership requests for this group, please visit:
%3$s

To view %4$s\'s profile: %5$s

---------------------
',

// bp-groups-notifications.php, mail 2, message part 2
'To disable these notifications please log in and go to: %s',

// bp-groups-notifications.php, mail 3, subject option 1
'Membership request for group "%s" accepted',

// bp-groups-notifications.php, mail 3, message part 1, option 1
'Your membership request for the group "%1$s" has been accepted.

To view the group please login and visit: %2$s

---------------------
',

// bp-groups-notifications.php, mail 3, subject option 1
'Membership request for group "%s" rejected', 'buddypress',

// bp-groups-notifications.php, mail 3, message part 1, option 1
'Your membership request for the group "%1$s" has been rejected.

To submit another request please log in and visit: %2$s

---------------------
',

// bp-groups-notifications.php, mail 3, message part 2
'To disable these notifications please log in and go to: %s',

// bp-groups-notifications.php, mail 4, subject
'You have been promoted in the group: "%s"',

// bp-groups-notifications.php, mail 4, message part 1
'You have been promoted to %1$s for the group: "%2$s".

To view the group please visit: %3$s

---------------------
',

// bp-groups-notifications.php, mail 4, message part 2
'To disable these notifications please log in and go to: %s',

// bp-groups-notifications.php, mail 5, subject
'You have an invitation to the group: "%s"',

// bp-groups-notifications.php, mail 5, message part 1
'One of your friends %1$s has invited you to the group: "%2$s".

To view your group invites visit: %3$s

To view the group visit: %4$s

To view %5$s\'s profile visit: %6$s

---------------------
',

// bp-groups-notifications.php, mail 5, message part 2
'To disable these notifications please log in and go to: %s',

// bp-members-functions.php, mail 1, subject
'Activate Your Account',

// bp-members-functions.php, mail 1, message
"Thanks for registering! To complete the activation of your account please click the following link:\n\n%1\$s\n\n",

// bp-messages-notifications.php, mail 1, subject
'New message from %s',

// bp-messages-notifications.php, mail 1, message part 1
'%1$s sent you a new message:

Subject: %2$s

"%3$s"

To view and read your messages please log in and visit: %4$s

---------------------
',

// bp-messages-notifications.php, mail 1, message part 2
'To disable these notifications, please log in and go to: %s',

// bp-settings-actions.php, mail 1, subject
'[%s] Verify your new email address',

// bp-settings-actions.php, mail 1, message
'Dear %1$s,

You recently changed the email address associated with your account on %2$s.
If this is correct, please click on the following link to complete the change:
%3$s

You can safely ignore and delete this email if you do not want to take this action or if you have received this email in error.

This email has been sent to %4$s.

Regards,
%5$s
%6$s'

);

}

?>
