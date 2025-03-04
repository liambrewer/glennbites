import type { PageProps, Product } from '@storefront/types';

import { Head } from '@inertiajs/react';

import ProductCard from '@storefront/Components/ProductCard';
import AppLayout from '@storefront/Layouts/AppLayout';

interface Props {
    products: Product[];
}

export default function ProductsIndex({ auth, products }: PageProps & Props) {
    return (
        <>
            <Head title="Products" />

            <AppLayout>
                {products.map((product) => (
                    <ProductCard key={product.id} product={product} />
                ))}
            </AppLayout>
        </>
    );
}
