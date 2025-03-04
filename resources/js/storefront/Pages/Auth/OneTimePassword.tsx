import type { FormEventHandler } from "react";

import { useForm } from "laravel-precognition-react-inertia";

import AuthLayout from '@storefront/Layouts/AuthLayout';
import TextInput from "@storefront/Components/UI/TextInput";
import Button from "@storefront/Components/UI/Button";
import {useMask} from "@react-input/mask";
import {ArrowPathIcon, CheckIcon} from "@heroicons/react/24/solid";
import {Head} from "@inertiajs/react";

type OneTimePasswordForm = {
    code: string;
};

type Props = {
    email: string;
    url: string;
};

export default function AuthOneTimePassword({ email, url }: Props) {
    const form = useForm<OneTimePasswordForm>('post', url, {
        code: '',
    });

    const codeInputRef = useMask({
        mask: '___-___',
        replacement: { _: /\d/ },
    });

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        form.submit();
    };

    return (
        <>
            <Head title="One Time Password" />

            <AuthLayout title="One Time Password" description={`Enter the one-time password sent to ${email}`}>
                <form className="space-y-8" onSubmit={handleSubmit}>
                    <TextInput
                        inputRef={codeInputRef}
                        label="Code"
                        type="text"
                        placeholder="123-456"
                        required
                        value={form.data.code}
                        onChange={(e) => form.setData('code', e.target.value)}
                        onBlur={() => form.validate('code')}
                        error={form.errors.code}
                    />

                    <Button className="w-full" variant="primary" type="submit" disabled={form.processing} leftIcon={form.processing ? <ArrowPathIcon className="animate-spin" /> : <CheckIcon />}>
                        {form.processing ? 'Verifying Code...' : 'Verify Code'}
                    </Button>
                </form>
            </AuthLayout>
        </>
    );
}
