<template>
    <div class="container-fluid bg-dark text-light py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="mb-4">Customer Support</h1>
                <div class="card bg-secondary mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-3">Contact Us</h2>
                        <p class="card-text">We're here to help! If you have any questions or concerns, please don't
                            hesitate to reach out to us.</p>
                        <ul class="list-unstyled">
                            <li><strong>Email:</strong> support@beeshop.com</li>
                            <li><strong>Phone:</strong> +62 123 456 7890</li>
                            <li><strong>Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM WIB</li>
                        </ul>
                    </div>
                </div>
                <div class="card bg-secondary mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-3">FAQ</h2>
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item bg-dark">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed bg-secondary text-light" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq1">
                                        How do I track my order?
                                    </button>
                                </h3>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-light">
                                        You can track your order by logging into your account and visiting the "Order
                                        History" section. There, you'll find the tracking number and current status of
                                        your shipment.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item bg-dark">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed bg-secondary text-light" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq2">
                                        What is your return policy?
                                    </button>
                                </h3>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-light">
                                        We offer a 30-day return policy for most items. Products must be in their
                                        original condition and packaging. Please contact our support team to initiate a
                                        return.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item bg-dark">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed bg-secondary text-light" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Do you offer international shipping?
                                    </button>
                                </h3>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-light">
                                        Currently, we only ship within Indonesia. We're working on expanding our
                                        shipping options and hope to offer international shipping in the future.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="card bg-secondary">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-3">Submit a Support Ticket</h2>
                        <form @submit.prevent="submitSupportTicket">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control bg-dark text-light" id="name"
                                    v-model="ticket.name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control bg-dark text-light" id="email"
                                    v-model="ticket.email" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control bg-dark text-light" id="subject"
                                    v-model="ticket.subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control bg-dark text-light" id="message" rows="5"
                                    v-model="ticket.message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Ticket</button>
                        </form>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Support',
    data() {
        return {
            ticket: {
                name: '',
                email: '',
                subject: '',
                message: ''
            }
        }
    },
    methods: {
        submitSupportTicket() {
            // Here you would typically send the ticket data to your backend API
            console.log('Support ticket submitted:', this.ticket);
            alert('Thank you for your message. We will get back to you soon!');
            // Reset the form
            this.ticket = {
                name: '',
                email: '',
                subject: '',
                message: ''
            };
        }
    }
}
</script>

<style scoped>
.accordion-button:not(.collapsed) {
    background-color: #495057;
    color: #fff;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
}
</style>