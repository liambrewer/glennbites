import type { FormEventHandler } from "react";

import { useForm } from "@inertiajs/react";

import AuthLayout from '@storefront/Layouts/AuthLayout';
import TextInput from "@storefront/Components/UI/TextInput";
import Button from "@storefront/Components/UI/Button";
import {useMask} from "@react-input/mask";
import {CheckIcon} from "@heroicons/react/24/solid";

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

    const codeInputRef = useMask({
        mask: '___-___',
        replacement: { _: /\d/ },
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(url);
    };

    return (
        <AuthLayout title="One Time Password" description={`Enter the one-time password sent to ${email}`}>
            <form className="space-y-8" onSubmit={submit}>
                <TextInput inputRef={codeInputRef} label="OTP Code" type="text" placeholder="123-456" required value={data.code} onChange={(e) => setData('code', e.target.value)} error={errors.code} />

                <Button className="w-full" variant="primary" type="submit" disabled={processing} leftIcon={<CheckIcon />}>Verify</Button>
            </form>
        </AuthLayout>
    );
}
