import type { PageProps } from '@storefront/types';

import type { FormEventHandler } from 'react';

import { useForm } from 'laravel-precognition-react-inertia';

import { ArrowPathIcon, CheckIcon } from '@heroicons/react/24/solid';
import { Head } from '@inertiajs/react';
import Button from '@storefront/Components/UI/Button';
import TextInput from '@storefront/Components/UI/TextInput';
import AuthLayout from '@storefront/Layouts/AuthLayout';

type OnboardingForm = {
    first_name: string;
    last_name: string;
};

export default function Onboarding({ auth }: PageProps) {
    const form = useForm<OnboardingForm>('post', route('storefront.onboarding.store'), {
        first_name: '',
        last_name: '',
    });

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        form.submit();
    };

    return (
        <>
            <Head title="Finish Account Setup" />

            <AuthLayout title="Finish Account Setup" description="Please provide your first and last name to finish setting up your account.">
                <form className="space-y-8" onSubmit={handleSubmit}>
                    <div className="space-y-4">
                        <TextInput label="Email" type="email" value={auth.user.email} disabled />

                        <TextInput
                            label="First Name"
                            type="text"
                            placeholder="First Name"
                            required
                            value={form.data.first_name}
                            onChange={(e) => form.setData('first_name', e.target.value)}
                            onBlur={() => form.validate('first_name')}
                            error={form.errors.first_name}
                        />

                        <TextInput
                            label="Last Name"
                            type="text"
                            placeholder="Last Name"
                            required
                            value={form.data.last_name}
                            onChange={(e) => form.setData('last_name', e.target.value)}
                            onBlur={() => form.validate('last_name')}
                            error={form.errors.last_name}
                        />
                    </div>

                    <Button
                        className="w-full"
                        variant="primary"
                        type="submit"
                        disabled={form.processing}
                        leftIcon={form.processing ? <ArrowPathIcon className="animate-spin" /> : <CheckIcon />}
                    >
                        {form.processing ? 'Finishing Setup...' : 'Finish Setup'}
                    </Button>
                </form>
            </AuthLayout>
        </>
    );
}
