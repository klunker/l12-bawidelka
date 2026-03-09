'use client';
import { Button } from '@radix-ui/themes';
import React from 'react';

interface CtaSectionProps {
    title: string;
    description: string;
    buttonLabel: string;
    func?: () => void;
}

const CtaSection: React.FC<CtaSectionProps> = ({
    title,
    description,
    buttonLabel,
    func,
}) => {
    return (
        <section className="cta" id="contact">
            <div className="cta-container">
                <div className="cta-content">
                    <h2 className="cta-title">{title}</h2>
                    <p className="cta-description">{description}</p>
                    <Button
                        size={'3'}
                        radius={'full'}
                        type={'button'}
                        className="btn btn-lg btn-primary"
                        onClick={func}
                    >
                        {buttonLabel}
                    </Button>
                </div>
            </div>
        </section>
    );
};

export default CtaSection;
