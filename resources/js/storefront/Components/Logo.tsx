import decaLogo from '@storefront/assets/deca.png';
import cn from '@storefront/Utils/cn';

type LogoProps = {
    className?: string;
};

export default function Logo({ className }: LogoProps) {
    return <img src={decaLogo} alt="Deca Logo" className={cn('size-12', className)} />;
}
