<?php
session_set_cookie_params(0, '/', 'localhost', false, true);
session_start();
require_once('templates/common.php');
require_once('database/connection.php');
require_once('database/messages.php');
require_once('templates/categories.php');
require_once('database/items.php');

$db = getDatabaseConnection();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}
$cats = getCategories($db);
$username = htmlspecialchars($_SESSION['username']);
$otherUser = htmlspecialchars($_GET['user']);
$itemId = htmlspecialchars($_GET['item']);
$transaction = getTransaction($db, $itemId);
$itemName = htmlspecialchars(getItemName($db, $itemId));
$seller = htmlspecialchars(getSellerUsername($db, $itemId));
date_default_timezone_set('Europe/Lisbon');
$messages = getMessages($db, $username, $otherUser, $itemId);
$transactionStatus = $transaction['status'];
output_header();
output_categories($db, $cats);

if (isset($_SESSION['payment_success'])) {
    echo "<p class='success'>" . htmlspecialchars($_SESSION['payment_success']) . "</p>";
    unset($_SESSION['payment_success']);
}
?>

<script>
    const transactionStatus = <?= json_encode($transactionStatus) ?>;
    const seller = <?= json_encode($seller) ?>;
    const otherUser = <?= json_encode($otherUser) ?>;
    const itemId = <?= json_encode($itemId) ?>;
    const username = <?= json_encode($username) ?>;
</script>
<div class='messages'>
    <h2>Messages with <a href="seller.php"><?= htmlspecialchars($otherUser) ?></a> about <?= htmlspecialchars($itemName) ?></h2>
    <div class="msg-container">
        <?php foreach ($messages as $message) {
            $class = $message['sender'] === $username ? 'user' : 'other_user';
            $date = date('F j, Y, g:i a', $message['timestamp']);
        ?>
            <p id="message-<?= htmlspecialchars($message['id']) ?>" class="<?= htmlspecialchars($class) ?>">
                <?php if ($message['price'] === null) { ?>
                    <strong><?= htmlspecialchars($message['sender']) ?>:</strong>
                <?php } ?>
                <?php if ($message['offer_accepted'] && $transaction['status'] != 'sold') { ?>
                    <?php if ($username !== $seller) { ?>
                        <a href='checkout.php?price=<?= htmlspecialchars($message['price']) ?>&item_id=<?= htmlspecialchars($itemId) ?>&user=<?= htmlspecialchars($otherUser) ?>' class='accept-offer'>Proceed to checkout</a>
                    <?php } else { ?>
                        You accepted the offer of <?= htmlspecialchars($message['price']) ?> €.
                    <?php } ?>
                <?php } else { ?>
                    <?php if ($message['price'] !== null && $transaction['status'] == 'sold') { ?>
                        Item Sold!
                    <?php } else if ($message['price'] !== null) { ?>
                        <?php if ($message['sender'] === $username) { ?>
                            You sent a proposal for <?= htmlspecialchars($message['price']) ?> €
                        <?php } else { ?>
                            <?php if ($username === $seller) { ?>
                                Buyer's proposal: <?= htmlspecialchars($message['price']) ?> €
                                <br>
                                <?php if ($transaction['status'] != 'sold') { ?>
                                    <a href='api_accept_offer.php?price=<?= htmlspecialchars($message['price']) ?>&item_id=<?= htmlspecialchars($itemId) ?>&message_id=<?= htmlspecialchars($message['id']) ?>&user=<?= htmlspecialchars($otherUser) ?>' class='accept-offer'>Accept Offer</a>
                                <?php } ?>
                            <?php } else { ?>
                                Seller's proposal: <?= htmlspecialchars($message['price']) ?> €
                                <?php if ($transaction['status'] != 'sold') { ?>
                                    <a href='api_accept_offer.php?price=<?= htmlspecialchars($message['price']) ?>&item_id=<?= htmlspecialchars($itemId) ?>&message_id=<?= htmlspecialchars($message['id']) ?>&user=<?= htmlspecialchars($otherUser) ?>' class='accept-offer'>Accept Offer</a>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <?= htmlspecialchars($message['message_text']) ?>
                    <?php } ?>
                <?php } ?>
                <br><small>Sent on <?= htmlspecialchars($date) ?></small>
            </p>
        <?php } ?>
    </div>
    <form id="messageForm">
        <input type="text" id="messageText" placeholder="Write your message here..." required>
        <button type="button" onclick="sendMessage()">Send</button>
    </form>
    <?php if ( $transaction['status'] != 'sold') { ?>
        <form id="proposalForm">
            <input type="number" id="proposalPrice" placeholder="Proposed Price" required>
            <button type="button" onclick="sendProposal()">Send Proposal</button>
        </form>
    <?php } ?>
</div>
<script src="scripts/manage_messages.js" defer></script>
<script src="scripts/send_messages.js" defer></script>

<?php 
output_footer();
?>
