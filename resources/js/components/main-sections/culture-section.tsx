'use client';
import React from 'react';

class CultureSection extends React.Component {
    render() {
        return (
            <section className="culture-section" id="culture">
                <div className="culture-container">
                    <div className="culture-header">
                        <h2 className="values-title">
                            Polska Kultura i Tradycja
                        </h2>
                        <p className="values-subtitle">
                            Łączymy nowoczesność z dziedzictwem
                        </p>
                    </div>
                    <div className="culture-grid">
                        <div className="culture-card">
                            <div className="culture-icon">
                                <i className="fas fa-tree"></i>
                            </div>
                            <h3 className="culture-title">Przyroda</h3>
                            <p className="culture-description">
                                Lasy, jeziora i góry - uczymy dzieci miłości do
                                polskiej natury
                            </p>
                        </div>
                        <div className="culture-card">
                            <div className="culture-icon">
                                <i className="fas fa-utensils"></i>
                            </div>
                            <h3 className="culture-title">Kuchnia Polska</h3>
                            <p className="culture-description">
                                Pierogi, bigos i placki - gotowanie jako lekcja
                                kultury
                            </p>
                        </div>
                        <div className="culture-card">
                            <div className="culture-icon">
                                <i className="fas fa-music"></i>
                            </div>
                            <h3 className="culture-title">Muzyka i Taniec</h3>
                            <p className="culture-description">
                                Polonez, mazur i krakowiak - taniec tożsamości
                                narodowej
                            </p>
                        </div>
                        <div className="culture-card">
                            <div className="culture-icon">
                                <i className="fas fa-chess"></i>
                            </div>
                            <h3 className="culture-title">Gry i Zabawy</h3>
                            <p className="culture-description">
                                Tradycyjne gry planszowe i podwórkowe zabawy
                                integrują pokolenia
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        );
    }
}

export default CultureSection;
