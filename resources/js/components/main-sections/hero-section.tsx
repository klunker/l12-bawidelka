'use client';
import { Button } from '@radix-ui/themes';

export const HeroSection = () => {
    const redirectToServices = () => {
        window.location.href = `/#services`;
    };
    return (
        <section className="hero" id="home">
            <div className="animated-bg">
                <div className="shape shape-1"></div>
                <div className="shape shape-2"></div>
                <div className="shape shape-3"></div>
            </div>
            <div className="hero-container">
                <div className="hero-content">
                    <div className="hero-label">
                        <span>
                            Wyjątkowe wydarzenia, które zostają w pamięci
                            dzieci.
                        </span>
                    </div>
                    <h1 className="hero-title">
                        <span className="highlight-text">
                            Tworzymy przestrzeń,
                        </span>
                        <br />{' '}
                        <span className="font-extrabold">
                            w&nbsp;której dzieci rosną z&nbsp;radością.
                            <br />
                            <br />
                            Opole&nbsp;i&nbsp;Rydułtowy
                        </span>
                    </h1>
                    <p className="hero-description">
                        Miejsce tworzone z pasji i miłości do dziecięcej
                        kreatywności
                    </p>
                    <div className="hero-buttons">
                        <Button
                            size={'3'}
                            radius={'full'}
                            type={'button'}
                            className="btn btn-lg btn-primary"
                            onClick={redirectToServices}
                        >
                            Oferty
                        </Button>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default HeroSection;
