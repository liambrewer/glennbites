import type { FormEventHandler } from 'react';

import { Head } from '@inertiajs/react';
import { useForm } from 'laravel-precognition-react-inertia';
import { ArrowPathIcon, EnvelopeIcon } from '@heroicons/react/24/solid';

import Button from '@storefront/components/ui/button';
import TextInput from '@storefront/components/ui/text-input';
import AuthLayout from '@storefront/layouts/auth-layout';

type LoginForm = {
    email: string;
};

export default function AuthLogin() {
    const form = useForm<LoginForm>('post', route('storefront.auth.send-one-time-password'), {
        email: '',
    });

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        form.submit();
    };

    return (
        <>
            <Head title="Login" />

            <AuthLayout title="Login to Glennbites" description="Enter your email to receive a one-time password">
                <form className="space-y-8" onSubmit={handleSubmit}>
                    <TextInput
                        label="Email"
                        type="email"
                        placeholder="first.last00@k12.leanderisd.org"
                        required
                        value={form.data.email}
                        onChange={(e) => form.setData('email', e.target.value)}
                        onBlur={() => form.validate('email')}
                        error={form.errors.email}
                    />

                    <Button
                        className="w-full"
                        variant="primary"
                        type="submit"
                        disabled={form.processing}
                        leftIcon={form.processing ? <ArrowPathIcon className="animate-spin" /> : <EnvelopeIcon />}
                    >
                        {form.processing ? 'Sending Code...' : 'Send Code'}
                    </Button>
                </form>
            </AuthLayout>
        </>
    );
}
