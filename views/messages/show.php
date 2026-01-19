<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Conversations</h3>
                </div>
                <div class="list-group list-group-flush">
                    <a href="/messages" class="list-group-item list-group-item-action">
                        <i class="fas fa-arrow-left me-2"></i> Back to all conversations
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Conversation with <?= e($participant['name']) ?>
                    </h4>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: auto;">
                    <?php if (empty($messages)): ?>
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-comment-slash fa-3x mb-3"></i>
                            <p>No messages yet. Start the conversation!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="d-flex mb-3 <?= $message['sender_user_id'] == $currentUser['id'] ? 'justify-content-end' : 'justify-content-start' ?>">
                                <div class="max-width-70">
                                    <div class="card <?= $message['sender_user_id'] == $currentUser['id'] ? 'bg-primary text-white' : 'bg-light' ?>">
                                        <div class="card-body">
                                            <p class="mb-1"><?= e($message['body_content']) ?></p>
                                            <small class="<?= $message['sender_user_id'] == $currentUser['id'] ? 'text-white-50' : 'text-muted' ?>">
                                                <?= e(date('d M Y, H:i', strtotime($message['sent_at']))) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <form action="/messages" method="post" class="d-flex gap-2">
                        <input type="hidden" name="recipient_id" value="<?= (int)$participant['id'] ?>">
                        <input type="hidden" name="subject" value="Re: Conversation">
                        <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.max-width-70 {
    max-width: 70%;
}
</style>
