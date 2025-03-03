import type { PageProps } from "@storefront/types";

import type { FormEventHandler } from "react";

import { useForm } from "@inertiajs/react";

import AuthLayout from '@storefront/Layouts/AuthLayout';

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
        <AuthLayout>
            <h1>Onboarding</h1>

            <span>Logged in as: {auth.user.email}</span>

            <form onSubmit={submit}>
                <input type="text" value={data.first_name} onChange={(e) => setData('first_name', e.target.value)} />
                {errors.first_name && <div>{errors.first_name}</div>}

                <input type="text" value={data.last_name} onChange={(e) => setData('last_name', e.target.value)} />
                {errors.last_name && <div>{errors.last_name}</div>}

                <button type="submit" disabled={processing}>Submit</button>
            </form>
        </AuthLayout>
    );
}
