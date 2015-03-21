<?php

    function DQGetRecentComments($parameters) {
        // If API key or forum name is not defined, return false.

        if(!isset($parameters['APIKey']) || !isset($parameters['forumName'])) return FALSE;
        
        // If maximum comment count is not defined, set it to 25.
        if(!isset($parameters['commentCount'])) $parameters['commentCount'] = 25;
        
        // If maximum comment length is not defined, set it to 100.
        if(!isset($parameters['commentLength'])) $parameters['commentLength'] = 100;
        
        // Building up the Disqus comments API link.
        $DQCommentsAPILink = "http://disqus.com/api/3.0/posts/list.json?limit={$parameters['commentCount']}&api_key={$parameters['APIKey']}&forum={$parameters['forumName']}&include=approved";
        
        // Get the json comments response.
        $DQJsonCommentResponse = DQGetJson($DQCommentsAPILink);
        
        // If the cURL session was successful.
        if($DQJsonCommentResponse != FALSE) {
            
            // Converting json response into PHP array.
            $DQRawComments = @json_decode($DQJsonCommentResponse, true);
            
            // Extract just the comments from the response array.
            $DQComments = $DQRawComments['response'];
            
            // Traversing through every element of the comments array.
            for($index = 0; $index < count($DQComments); $index++) {
			
                // Building up the Disqus thread API link.
                $DQThreadAPILink = "http://disqus.com/api/3.0/threads/details.json?api_key={$parameters['APIKey']}&thread={$DQComments[$index]['thread']}";

                // Get the json thread response.
                $DQJsonThreadResponse = DQGetJson($DQThreadAPILink);

                // Converting json response into PHP array.
                $DQRawThread = @json_decode($DQJsonThreadResponse, true);

                // Extract just the thread inforamtion from the response array.
                $DQThread = $DQRawThread['response'];

                // Setting up the comment keys.
                if($DQThread != FALSE) {
                    $DQComments[$index]['pageTitle'] = $DQThread['title'];
                    $DQComments[$index]['pageURL'] = $DQThread['link'];
                } else {
                    $DQComments[$index]['pageTitle'] = 'Page Not Found';
                    $DQComments[$index]['pageURL'] = '#';

                }

                $DQComments[$index]['authorName'] = $DQComments[$index]['author']['name'];

                $DQComments[$index]['authorProfileURL'] = $DQComments[$index]['author']['profileUrl'];

                $DQComments[$index]['authorAvatar'] = $DQComments[$index]['author']['avatar']['cache'];

                $DQComments[$index]['message'] = DQLimitLength($DQComments[$index]['raw_message'], $parameters['commentLength']);

                

                // Unsetting exttra keys.

                unset($DQComments[$index]['isJuliaFlagged']);

                unset($DQComments[$index]['isFlagged']);

                unset($DQComments[$index]['forum']);

                unset($DQComments[$index]['parent']);

                unset($DQComments[$index]['author']);

                unset($DQComments[$index]['media']);

                unset($DQComments[$index]['isDeleted']);

                unset($DQComments[$index]['isApproved']);

                unset($DQComments[$index]['dislikes']);

                unset($DQComments[$index]['raw_message']);

                unset($DQComments[$index]['id']);

                unset($DQComments[$index]['thread']);

                unset($DQComments[$index]['numReports']);

                unset($DQComments[$index]['isEdited']);

                unset($DQComments[$index]['isSpam']);

                unset($DQComments[$index]['isHighlighted']);

                unset($DQComments[$index]['points']);

                unset($DQComments[$index]['likes']);

                

            }

            

            // Returning the comments array.

            return $DQComments;

        }

    }

    

    function DQGetJson($DQAPILink) {

        

        // Creating a new cURL resource for comments.

        $DQcURL = curl_init();

        

        // Not to include the header in the output.

        curl_setopt($DQcURL, CURLOPT_HEADER, FALSE);

        

        // Setting the URL from where to fetch the content.

        curl_setopt($DQcURL, CURLOPT_URL, $DQAPILink);

        

        // Return the fetched content as a string instead of outputting it out directly.

        curl_setopt($DQcURL, CURLOPT_RETURNTRANSFER, TRUE);

        

        // Forcing the use of a new connection instead of a cached one.

        curl_setopt($DQcURL, CURLOPT_FRESH_CONNECT, TRUE);

        

        // Forcing the connection to explicitly close when it has finished processing, and not be pooled for reuse.

        curl_setopt($DQcURL, CURLOPT_FORBID_REUSE, TRUE);

        

        // Executing the current cURL session.

        $DQJsonResponse = curl_exec($DQcURL);

        

        // Close the current cURL session.

        curl_close($DQcURL);

        

        return $DQJsonResponse;

        

    }

    

    function DQLimitLength($string, $maxLength) {

        if(strlen($string) <= $maxLength) {

            return $string;

        } else {

            return substr($string, 0, $maxLength)."...";

        }

    }

    

?>