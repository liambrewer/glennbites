import type { InputHTMLAttributes, PropsWithChildren, Ref } from "react";

import cn from "@storefront/Utils/cn";

interface TextInputProps extends InputHTMLAttributes<HTMLInputElement> {
    label: string;
    inputRef?: Ref<HTMLInputElement>;
    error?: string;
}

export default function TextInput({
    type = "text",
    label,
    error,
    className,
    inputRef,
    ...inputProps
}: PropsWithChildren<TextInputProps>) {
    const isError = !!error;

    return (
        <label className={cn("flex flex-col gap-1.5", className)}>
            <span
                className={cn("text-sm font-semibold", {
                    "after:content-['*'] after:text-xs after:text-red-500 after:ml-0.5":
                        inputProps.required,
                })}
            >
                {label}
            </span>
            <input
                className={cn(
                    "px-3 py-2.5 text-sm border bg-white rounded ring-blue-200 duration-150 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring read-only:text-gray-400 read-only:bg-gray-100",
                    {
                        "border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-200":
                            isError,
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
