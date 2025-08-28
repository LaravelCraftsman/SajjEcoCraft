@extends('layouts.frontend')

@section('title', 'Contact Us')

@section('content')
    <main>
        <div class="mb-4 pb-4"></div>
        <section class="contact-us container">
            <div class="mw-930">
                <h2 class="page-title">CONTACT US</h2>
            </div>
        </section>

        <section class="google-map mb-5">
            <h2 class="d-none">Contact US</h2>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3673.9274592765128!2d72.4644024747682!3d22.952898518925732!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e91ecad236e11%3A0xb31c67106d35ec24!2sSajj%20Decor!5e0!3m2!1sen!2sin!4v1744667291067!5m2!1sen!2sin"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>


        <section class="contact-us container">
            <div class="mw-930">
                @if ($branches->count() > 0)
                    <div class="row mb-5">
                        @foreach ($branches as $item)
                            <div class="col-lg-6">
                                <h3 class="mb-4">{{ $item->title }}</h3>
                                <p class="mb-4">{{ $item->address }}</p>
                                <p class="mb-4">{{ $item->email_address }}<br>{{ $item->phone_number }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="contact-us__form">
                    @include('partials.alerts')
                    <form name="contact-us-form">
                        <h3 class="mb-5">Get In Touch</h3>

                        <div class="form-floating my-4">
                            <input type="text" class="form-control" id="contact_us_name" name="name"
                                placeholder="Name *" required>
                            <label for="contact_us_name">Name *</label>
                        </div>

                        <div class="form-floating my-4">
                            <input type="email" class="form-control" id="contact_us_email" name="email"
                                placeholder="Email address *" required>
                            <label for="contact_us_email">Email address *</label>
                        </div>

                        <div class="my-4">
                            <textarea id="contact_us_message" name="message" class="form-control form-control_gray" placeholder="Your Message"
                                cols="30" rows="8" required></textarea>
                        </div>

                        <div class="my-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[name="contact-us-form"]');
            const alertContainer = document.createElement('div');
            form.parentNode.insertBefore(alertContainer, form);

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Clear previous alerts
                alertContainer.innerHTML = '';

                // Gather form data
                const name = document.getElementById('contact_us_name').value.trim();
                const email = document.getElementById('contact_us_email').value.trim();
                const message = form.querySelector('textarea').value.trim();

                // Basic client-side validation
                if (!name || !email || !message) {
                    alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Whoops!</strong> Please fill all required fields.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
                    return;
                }

                try {
                    const response = await fetch('{{ url('/api/contact-request') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            // Add CSRF token if needed here, but usually not for API routes
                        },
                        body: JSON.stringify({
                            name,
                            email,
                            message
                        }),
                    });

                    const data = await response.json();

                    if (response.ok) {
                        alertContainer.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${data.message || 'Your message has been sent successfully.'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;

                        // Reset form fields
                        form.reset();
                    } else {
                        // Show validation errors or other messages
                        let errorsHtml = '';

                        if (data.errors) {
                            errorsHtml = '<ul class="mb-0">';
                            for (const key in data.errors) {
                                data.errors[key].forEach(error => {
                                    errorsHtml += `<li>${error}</li>`;
                                });
                            }
                            errorsHtml += '</ul>';
                        } else if (data.message) {
                            errorsHtml = `<p>${data.message}</p>`;
                        } else {
                            errorsHtml = '<p>Something went wrong. Please try again later.</p>';
                        }

                        alertContainer.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Whoops!</strong> Please fix the following issues:<br>${errorsHtml}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    }
                } catch (error) {
                    alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Unable to send message. Please try again later.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
                    console.error('Contact request error:', error);
                }
            });
        });
    </script>
@endsection
