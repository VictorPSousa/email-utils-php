<?php

//require 'composer.json';
include_once 'Mailgun.php';

# First, instantiate the SDK with your API credentials
$mg = Mailgun::create('1df6ec32-e19be223');

# Now, compose and send your message.
# $mg->messages()->send($domain, $params);
$mg->messages()->send('sandbox0dfa3b92797c4836a8d757ae0891f4f0.mailgun.org', [
  'from'    => 'Excited User <mailgun@sandbox0dfa3b92797c4836a8d757ae0891f4f0.mailgun.org>',
  'to'      => 'Baz <victor.pdsousa1@gmail.com>',
  'subject' => 'Hello',
  'text'    => 'Testing some Mailgun awesomness!'
]);