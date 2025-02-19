import type {PageProps, Product} from "@/types";

import {Head} from "@inertiajs/react";

import AppLayout from "@/Layouts/AppLayout";
import ProductCard from "@/Components/ProductCard";

interface Props {
    products: Product[];
}

export default function ProductsIndex({ products }: PageProps & Props) {
    return (
        <>
            <Head title="Products" />

            <AppLayout>
                {products.map(product => <ProductCard key={product.id} product={product} />)}
            </AppLayout>
        </>
    )
}
