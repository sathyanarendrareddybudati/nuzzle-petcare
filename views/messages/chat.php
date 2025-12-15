<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Chat with <?= e($participant['name']) ?></h3>
                    <a href="/messages" class="btn btn-secondary btn-sm">Back to Conversations</a>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: auto;">
                    <?php foreach ($messages as $message): ?>
                        <?php
                        $isMine = ($message['sender_user_id'] == $_SESSION['user']['id']);
                        $justify = $isMine ? 'end' : 'start';
                        ?>
                        <div class="d-flex justify-content-<?= $justify ?> mb-3">
                            <div class="card" style="width: 70%;">
                                <div class="card-body">
                                    <p class="card-text"><?= e($message['body_content']) ?></p>
                                    <small class="text-muted">
                                        <?= e(date('d M Y, h:i A', strtotime($message['sent_at']))) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div class="card-footer">
                    <form action="/messages/send" method="post">
                        <input type="hidden" name="recipient_id" value="<?= e($participant['id']) ?>">
                        <div class="input-group">
                            <input type="text" name="body" class="form-control" placeholder="Type your message..." required>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>