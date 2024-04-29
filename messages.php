<?php
    session_start();
    require_once('templates/common.php');
    require_once('database/connection.php');
    require_once('database/messages.php');
    require_once('templates/categories.php');

    $db = getDatabaseConnection();
    $cats = getCategories($db);
    // Get the current user's username, the other user's username, and the item_id
    $username = $_SESSION['username'];
    $otherUser = $_GET['user'];
    $itemId = $_GET['item'];
    date_default_timezone_set('Europe/Lisbon');
    
    // Get the messages
    $messages = getMessages($db, $username, $otherUser, $itemId);
    output_header();
    output_categories($db, $cats);
    if ($username != $seller) { ?>
    <h3 class="modalheader">Negotiate Price</h3>
    <form action="send_message.php" method="post" id="negotiateFields">
        <input type="hidden" name="receiver" value="<?= $otherUser ?>">
        <input type="hidden" name="item_id" value="<?= $itemId ?>">
        <input type="number" name="price" placeholder="Proposed Price" required>
        <button type="submit">Send Proposal</button>
    </form>
    <?php } ?>
 
<div class='messages'>
    <h2>Messages with <?= $otherUser ?> about item <?= $itemId ?></h2>
    <?php foreach($messages as $message){ 
        $class = $message['sender'] === $username ? 'user' : 'other_user';
        $date = date('F j, Y, g:i a', $message['timestamp']); 
    ?>
        <p class="<?= $class ?>">
    <strong><?= $message['sender'] ?>:</strong>
    <?php if ($message['price'] !== null) { ?>
        <?php if ($message['sender'] === $username) { //if the sender is the user?>
            You sent a proposal for <?= $message['price'] ?> €
        <?php } else { //if the sender is not the user?>
            <?php if ($username === $buyer) { //if the user is the buyer?>
                Seller's counter offer: <?= $message['price'] ?> €
            <?php } else { //if the user is the seller?>
                Will you buy it for <?= $message['price'] ?> €?
            <?php } ?>
            <br> 
            <a href='accept_offer.php?price=<?= $message['price'] ?>'>Accept Offer</a>
            <button onclick="showCounterOfferForm(<?= $itemId ?>)">Counter Offer</button>
            <div id="counter-offer-<?= $itemId ?>" style="display: none;">
                <form id="counter-offer-form-<?= $itemId ?>" onsubmit="event.preventDefault(); sendCounterOffer(<?= $itemId ?>, '<?= $otherUser ?>');">
                    <input type="number" name="new_price" placeholder="New Price" required>
                    <button type="submit">Submit New Price</button>
                </form>
            </div>
        <?php } ?>
    <?php } else { ?>
        <?= $message['message_text'] ?>
    <?php } ?>
    <br><small>Sent on <?= $date ?></small>
</p>
    <?php } ?>
    <form action="send_message.php" method="post">
        <input type="hidden" name="receiver" value="<?= $otherUser ?>">
        <input type="hidden" name="item_id" value="<?= $itemId ?>">
        <input type="text" name="message_text" placeholder="Write your message here...">
        <input type="submit" value="Send">
    </form>
</div>
<script src="/scripts/negotiate_price.js" defer></script>
<?php 
output_footer(); ?>