
<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Conversations</h3>
                </div>
                <div class="list-group list-group-flush">
                    <?php if (empty($conversations)): ?>
                        <div class="list-group-item">
                            <p class="text-muted">No conversations yet.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($conversations as $conversation): ?>
                            <a href="/messages/chat?participant_id=<?= e($conversation['participant_id']) ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?= e($conversation['participant_name']) ?></h5>
                                    <small><?= e(date('d M Y', strtotime($conversation['last_message_date']))) ?></small>
                                </div>
                                <p class="mb-1"><?= e(substr($conversation['last_message'], 0, 50)) ?>...</p>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="card-title">Select a Conversation</h2>
                    <p class="card-text text-muted">Choose a conversation from the list to view messages.</p>
                    <i class="fas fa-comments fa-5x text-light"></i>
                </div>
            </div>
        </div>
    </div>
</div>
