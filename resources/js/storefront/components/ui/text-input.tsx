import type { InputHTMLAttributes, PropsWithChildren, Ref } from 'react';

import cn from '@storefront/utils/cn';

interface TextInputProps extends InputHTMLAttributes<HTMLInputElement> {
    label: string;
    inputRef?: Ref<HTMLInputElement>;
    error?: string;
}

export default function TextInput({ type = 'text', label, error, className, inputRef, ...inputProps }: PropsWithChildren<TextInputProps>) {
    const isError = !!error;

    return (
        <label className={cn('flex flex-col gap-1.5', className)}>
            <span
                className={cn('text-sm font-semibold', {
                    "after:ml-0.5 after:text-xs after:text-red-500 after:content-['*']": inputProps.required,
                })}
            >
                {label}
            </span>
            <input
                className={cn(
                    'rounded border bg-white px-3 py-2.5 text-sm ring-blue-200 duration-150 read-only:bg-gray-50 read-only:text-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring',
                    {
                        'border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-200': isError,
                    },
                )}
                type={type}
                ref={inputRef}
                {...inputProps}
            />
            {isError && <p className="text-xs text-red-500">{error}</p>}
        </label>
    );
}
