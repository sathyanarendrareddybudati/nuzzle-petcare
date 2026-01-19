<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-envelope me-2"></i>
                        Send Message to <?= e($recipient['name']) ?>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="/messages" method="post">
                        <input type="hidden" name="recipient_id" value="<?= (int)$recipient['id'] ?>">
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" 
                                   placeholder="Enter message subject" required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" 
                                      placeholder="Type your message here..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/pets/<?= $_SERVER['HTTP_REFERER'] ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : '/' ?>" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
