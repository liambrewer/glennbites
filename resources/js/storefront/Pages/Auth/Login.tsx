import type { FormEventHandler } from "react";

import { useForm } from "@inertiajs/react";

import AuthLayout from '@storefront/Layouts/AuthLayout';
import TextInput from "@storefront/Components/UI/TextInput";
import Button from "@storefront/Components/UI/Button";
import {EnvelopeIcon} from "@heroicons/react/24/solid";

type LoginForm = {
    email: string;
}

export default function AuthLogin() {
    const { data, setData, post, processing, errors, reset } = useForm<LoginForm>({
        email: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('storefront.auth.send-one-time-password'));
    };

    return (
        <AuthLayout title="Login to Glennbites" description="Enter your email to receive a one-time password">
            <form className="space-y-8" onSubmit={submit}>
                <TextInput label="Email" type="email" placeholder="first.last00@k12.leanderisd.org" required value={data.email} onChange={(e) => setData('email', e.target.value)} error={errors.email} />

                <Button className="w-full" variant="primary" type="submit" disabled={processing} leftIcon={<EnvelopeIcon />}>Send Code</Button>
            </form>
        </AuthLayout>
    );
}
