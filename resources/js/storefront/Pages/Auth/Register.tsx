import type { FormEventHandler } from "react";

import { useForm } from "@inertiajs/react";

import AuthLayout from '@storefront/Layouts/AuthLayout';

type RegisterForm = {
    first_name: string;
    last_name: string;
}

type Props = {
    email: string;
}

export default function AuthRegister({ email }: Props) {
    const { data, setData, post, processing, errors } = useForm<RegisterForm>({
        first_name: '',
        last_name: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('storefront.auth.complete-registration'));
    };

    return (
        <AuthLayout>
            <h1>Register</h1>

            <form onSubmit={submit}>
                <input type="email" value={email} readOnly />

                <input autoComplete='given-name' type="text" value={data.first_name} onChange={(e) => setData('first_name', e.target.value)} />
                {errors.first_name && <div>{errors.first_name}</div>}

                <input autoComplete='family-name' type="text" value={data.last_name} onChange={(e) => setData('last_name', e.target.value)} />
                {errors.last_name && <div>{errors.last_name}</div>}

                <button type="submit" disabled={processing}>Register</button>
            </form>
        </AuthLayout>
    );
}
