<?php

class Friends extends FriendsSchema
{
    public static function follow($follower_id, $following_id): string
    {
        // check is user to follow does exist
        if (!User::doExists($following_id))
            return Utils::sendErr("user " . $following_id . " does not exist");

        // check is user is already following the same user
        if (self::isFollowing($follower_id, $following_id))
            return Utils::sendErr("you are already following user " . $following_id . ".");

        // finally, trigger follow action
        self::addConnection($follower_id, $following_id);

        // return true
        return Utils::sendMsg("you followed user " . $following_id, 200);
    }

    // get user's followers
    public static function followers($user_id)
    {
        $followers = self::getConnections($user_id, 'followers');

        if (!$followers)
            return Utils::send([]);

        return Utils::send($followers);
    }

    // get user's following
    public static function following($user_id)
    {
        $following = self::getConnections($user_id, 'following');

        if (!$following)
            return Utils::send([]);

        return Utils::send($following);
    }
}
