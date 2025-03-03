import type { FormEventHandler } from "react";

import { useForm } from "@inertiajs/react";

import AuthLayout from '@storefront/Layouts/AuthLayout';

type OneTimePasswordForm = {
    code: string;
};

type Props = {
    email: string;
    url: string;
};

export default function AuthOneTimePassword({ email, url }: Props) {
    const { data, setData, post, processing, errors, reset } = useForm<OneTimePasswordForm>({
        code: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(url);
    };

    return (
        <AuthLayout>
            <h1>One Time Password</h1>

            <span>Sent to: {email}</span>

            <form onSubmit={submit}>
                <input type="text" value={data.code} onChange={(e) => setData('code', e.target.value)} />
                {errors.code && <div>{errors.code}</div>}

                <button type="submit" disabled={processing}>Submit</button>
            </form>
        </AuthLayout>
    );
}
