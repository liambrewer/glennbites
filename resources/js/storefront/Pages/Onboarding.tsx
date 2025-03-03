import type { PageProps } from "@storefront/types";

import type { FormEventHandler } from "react";

import { useForm } from "@inertiajs/react";

import AuthLayout from '@storefront/Layouts/AuthLayout';
import TextInput from "@storefront/Components/UI/TextInput";
import Button from "@storefront/Components/UI/Button";
import {CheckIcon} from "@heroicons/react/24/solid";

type OnboardingForm = {
    first_name: string;
    last_name: string;
};

export default function Onboarding({ auth }: PageProps) {
    const { data, setData, post, processing, errors, reset } = useForm<OnboardingForm>({
        first_name: '',
        last_name: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('storefront.onboarding.store'));
    };

    return (
        <AuthLayout title="Finish Account Setup" description="Please provide your first and last name to finish setting up your account.">
            <form className="space-y-8" onSubmit={submit}>
                <div className="space-y-4">
                    <TextInput label="Email" type="email" value={auth.user.email} disabled required />

                    <TextInput label="First Name" type="text" placeholder="First Name" required value={data.first_name} onChange={(e) => setData('first_name', e.target.value)} error={errors.first_name} />

                    <TextInput label="Last Name" type="text" placeholder="Last Name" required value={data.last_name} onChange={(e) => setData('last_name', e.target.value)} error={errors.last_name} />
                </div>

                <Button className="w-full" variant="primary" type="submit" disabled={processing} leftIcon={<CheckIcon />}>Confirm Changes</Button>
            </form>
        </AuthLayout>
    );
}
