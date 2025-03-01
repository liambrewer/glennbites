import decaLogo from '../assets/deca.png';

export default function Logo() {
    return (
        <div className='logo'>
            <div className="logo-icon">
                <img className='deca' width={35} src={decaLogo} alt='deca logo'/>
            </div>
        </div>
    )
}
