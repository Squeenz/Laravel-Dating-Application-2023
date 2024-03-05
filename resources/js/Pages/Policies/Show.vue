<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Privacy Policy" />

    <GuestLayout :canLogin="canLogin" :canRegister="canRegister">
        <template #header>
            <h1 class="text-2xl italic text-white text-center">PRIVACY POLICY</h1>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:py-[1.5rem] bg-[#0A0A0A] shadow rounded-sm">
                <div class="flex flex-col justify-center p-[1rem] gap-3 text-white w-full">
                    <section id="introduction">
                        <p>
                            Effective Date: [Date]
                            Welcome to [Your Dating Site Name]! We understand that privacy is of utmost importance to our users. This Privacy Policy outlines how we collect, use, disclose, and protect your personal information when you use our website and services. By using [Your Dating Site Name], you agree to the terms and practices described in this policy.
                        </p>
                    </section>

                    <section id="information-collection">
                        <h2>Information We Collect</h2>
                        <p>
                            Registration Information: When you create an account, we collect your username, email address, password, and other optional information, including gender, date of birth, and profile photos.
                            Profile Information: You may choose to provide additional information on your profile, such as your interests, hobbies, and a personal description.
                            Communication Data: We collect data related to your interactions with other users, including messages, chat history, and other communications through our platform.
                            Usage Information: We collect information about your usage of our website, including pages visited, actions taken, and the device and browser used.
                            Location Information: With your consent, we may collect and process location information to enhance your user experience.
                        </p>
                    </section>

                    <section id="information-usage">
                        <h2>How We Use Your Information</h2>
                        <p>
                            We use the collected information for the following purposes:
                            Matching: To provide matchmaking services based on your preferences and interests.
                            Communication: To enable communication between users and facilitate connections.
                            Improvement: To enhance our website and services, we use data to analyze user behavior and preferences.
                            Security: To ensure the security and integrity of our platform.
                            Legal Compliance: To comply with applicable laws and regulations.
                        </p>
                    </section>

                    <section id="information-sharing">
                        <h2>Sharing Your Information</h2>
                        <p>
                            We do not sell, trade, or rent your personal information to third parties. However, we may share your information in the following circumstances:
                            With Other Users: We share your profile information, including your username and profile photos, with potential matches.
                            Service Providers: We may use third-party service providers to assist us with various aspects of our service, including hosting and data analysis.
                            Legal Obligations: We may disclose your information in response to legal requests or to protect our rights, privacy, safety, or property.
                        </p>
                    </section>

                    <section id="privacy-choices">
                        <h2>Your Privacy Choices</h2>
                        <p>
                            Profile Visibility: You can adjust your privacy settings to control who can see your profile and contact you.
                            Email Preferences: You can manage your email preferences for notifications and promotional materials.
                            Data Access and Deletion: You can request access to your data or request its deletion.
                        </p>
                    </section>

                    <section id="security">
                        <h2>Security</h2>
                        <p>
                            We employ security measures to protect your personal information from unauthorized access and disclosure. However, no data transmission over the internet can be guaranteed to be completely secure. You use our services at your own risk.
                        </p>
                    </section>

                    <section id="policy-changes">
                        <h2>Changes to this Privacy Policy</h2>
                        <p>
                            We reserve the right to update or modify this Privacy Policy. Any changes will be posted on our website with the effective date. Your continued use of our services constitutes your acceptance of the revised policy.
                        </p>
                    </section>

                    <section id="contact">
                        <h2>Contact Us</h2>
                        <p>
                            If you have questions or concerns about our Privacy Policy or the practices of [Your Dating Site Name], please contact us at [Your Contact Information].
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
