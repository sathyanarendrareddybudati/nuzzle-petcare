
<div class="container my-5">
    <h1 class="text-center mb-4">Frequently Asked Questions</h1>

    <div class="accordion" id="faqAccordion">
        <?php foreach ($faqs as $index => $faq): ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?php echo $index; ?>">
                    <button class="accordion-button <?php echo $index > 0 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $index; ?>" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $index; ?>">
                        <?php echo htmlspecialchars($faq['question']); ?>
                    </button>
                </h2>
                <
            </div>
        <?php endforeach; ?>
    </div>
</div>
