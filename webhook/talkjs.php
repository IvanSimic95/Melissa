<?php
// This is a vanilla PHP example of how to receive webhook requests and validate the signature, so
// you can be certain that the request was sent by TalkJS.
// 
// Some lines can be written differently if you use Laravel, those are shown in comments.

// Read the POST body in full + relevant headers
$payload = file_get_contents("php://input");
$signature = $_SERVER["HTTP_X_TALKJS_SIGNATURE"];
$timestamp = $_SERVER["HTTP_X_TALKJS_TIMESTAMP"];
// Laravel:
//   $payload = $request->getContent();
//   $signature = $request->header("X-TalkJS-Signature");
//   $timestamp = $request->header("X-TalkJS-Timestamp");


// Your secret key, as found in the TalkJS dashboard. In this example we read it from an environment
// variable, but this might work differently in your setup. Don't just hard-code it here:
// Make sure that you never share your secret key anywhere or commit it to code repositories.
$secret = "sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98";
// Laravel:
//   $secret = env("TALKJS_SECRET_KEY");


// Verify that the event is really originating from TalkJS and has not been tampered with.
$signedPayload = "$timestamp.$payload";
$expectedSignature = strtoupper(hash_hmac("sha256", $signedPayload, $secret));
if (!hash_equals($expectedSignature, $signature)) {
    error_log("invalid webhook event, signature does not match.");
    die();
}

error_log("TalkJS Payload: $payload");

// Parse the event payload JSON and handle it appropriately. Your custom code comes below.
$event = json_decode($payload);
$senderID = $event->data->sender->id;
$conversationID = $event->data->conversation->id;
switch ($event->type) {
    case "message.sent":
       
        

        if($conversationID <= 500000){ //Check if for Melissa
            error_log("Conversation ID: $conversationID | Melissa Psychic");
        }elseif($conversationID >= 500001){ //Check if for Isabella
            error_log("Conversation ID: $conversationID | Isabella Psychic");
        }else{
            error_log("Conversation ID: $conversationID | Who to apply to?");
        }



        break;

    default:
        // other events that you don't need falls here
        // save it or ignore it, according to your needs.
        break;
}