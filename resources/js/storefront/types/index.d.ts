import { Config } from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
}

export interface Product {
    id: number;
    sku?: string;
    name: string;
    description?: string;
    price: number;
    stock_on_hand: number;
    reserved_stock: number;
    max_per_order: number;
    image_url: string;

    available_stock: number;
    out_of_stock: boolean;

    created_at: string;
    updated_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
};
