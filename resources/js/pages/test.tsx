import { useEffect, useState } from 'react';

interface ClientInfo {
    ip: string;
    userAgent: string;
    acceptLanguage: string;
    accept: string;
}

interface DeviceInfo {
    screenWidth: number;
    screenHeight: number;
    windowWidth: number;
    windowHeight: number;
    pixelRatio: number;
    orientation: string;
}

export default function Test({ clientInfo }: { clientInfo: ClientInfo }) {
    const [deviceInfo, setDeviceInfo] = useState<DeviceInfo>({
        screenWidth: 0,
        screenHeight: 0,
        windowWidth: 0,
        windowHeight: 0,
        pixelRatio: 0,
        orientation: '',
    });

    useEffect(() => {
        const updateDeviceInfo = () => {
            setDeviceInfo({
                screenWidth: window.screen.width,
                screenHeight: window.screen.height,
                windowWidth: window.innerWidth,
                windowHeight: window.innerHeight,
                pixelRatio: window.devicePixelRatio,
                orientation: window.screen.orientation?.type || 'unknown',
            });
        };

        updateDeviceInfo();
        window.addEventListener('resize', updateDeviceInfo);
        window.addEventListener('orientationchange', updateDeviceInfo);

        return () => {
            window.removeEventListener('resize', updateDeviceInfo);
            window.removeEventListener('orientationchange', updateDeviceInfo);
        };
    }, []);

    return (
        <div className="min-h-screen bg-gray-100 p-4 sm:p-6 lg:p-8">
            <div className="mx-auto max-w-4xl">
                <h1 className="mb-6 text-2xl font-bold text-gray-800 sm:mb-8 sm:text-3xl">
                    Device & Client Information
                </h1>

                <div className="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-2">
                    {/* Device Resolution */}
                    <div className="rounded-lg bg-white p-4 shadow-md sm:p-6">
                        <h2 className="mb-3 text-lg font-semibold text-gray-700 sm:mb-4 sm:text-xl">
                            Device Resolution
                        </h2>
                        <div className="space-y-2">
                            <div className="flex justify-between">
                                <span className="text-sm text-gray-600 sm:text-base">
                                    Screen Width:
                                </span>
                                <span className="font-mono text-sm font-medium sm:text-base">
                                    {deviceInfo.screenWidth}px
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-sm text-gray-600 sm:text-base">
                                    Screen Height:
                                </span>
                                <span className="font-mono text-sm font-medium sm:text-base">
                                    {deviceInfo.screenHeight}px
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-sm text-gray-600 sm:text-base">
                                    Window Width:
                                </span>
                                <span className="font-mono text-sm font-medium sm:text-base">
                                    {deviceInfo.windowWidth}px
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-sm text-gray-600 sm:text-base">
                                    Window Height:
                                </span>
                                <span className="font-mono text-sm font-medium sm:text-base">
                                    {deviceInfo.windowHeight}px
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-sm text-gray-600 sm:text-base">
                                    Pixel Ratio:
                                </span>
                                <span className="font-mono text-sm font-medium sm:text-base">
                                    {deviceInfo.pixelRatio}
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-sm text-gray-600 sm:text-base">
                                    Orientation:
                                </span>
                                <span className="font-mono text-sm font-medium sm:text-base">
                                    {deviceInfo.orientation}
                                </span>
                            </div>
                        </div>
                    </div>

                    {/* Client Information */}
                    <div className="rounded-lg bg-white p-4 shadow-md sm:p-6">
                        <h2 className="mb-3 text-lg font-semibold text-gray-700 sm:mb-4 sm:text-xl">
                            Client Information
                        </h2>
                        <div className="space-y-2">
                            <div className="flex justify-between">
                                <span className="text-sm text-gray-600 sm:text-base">
                                    IP Address:
                                </span>
                                <span className="font-mono text-xs font-medium sm:text-sm">
                                    {clientInfo.ip}
                                </span>
                            </div>
                            <div className="flex flex-col">
                                <span className="mb-1 text-sm text-gray-600 sm:text-base">
                                    User Agent:
                                </span>
                                <span className="rounded bg-gray-50 p-2 font-mono text-xs break-all">
                                    {clientInfo.userAgent}
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-sm text-gray-600 sm:text-base">
                                    Accept Language:
                                </span>
                                <span className="font-mono text-xs font-medium sm:text-sm">
                                    {clientInfo.acceptLanguage}
                                </span>
                            </div>
                            <div className="flex flex-col">
                                <span className="mb-1 text-sm text-gray-600 sm:text-base">
                                    Accept:
                                </span>
                                <span className="rounded bg-gray-50 p-2 font-mono text-xs break-all">
                                    {clientInfo.accept}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Browser Resolution */}
                <div className="mt-4 rounded-lg bg-white p-4 shadow-md sm:mt-6 sm:p-6">
                    <h2 className="mb-3 text-lg font-semibold text-gray-700 sm:mb-4 sm:text-xl">
                        Browser Resolution
                    </h2>
                    <div className="grid grid-cols-2 gap-2 sm:gap-4">
                        <div className="rounded-lg bg-blue-50 p-3 text-center sm:p-4">
                            <div className="text-lg font-bold text-blue-600 sm:text-2xl">
                                {deviceInfo.windowWidth}x
                                {deviceInfo.windowHeight}
                            </div>
                            <div className="mt-1 text-xs text-gray-600 sm:text-sm">
                                Viewport Size
                            </div>
                        </div>
                        <div className="rounded-lg bg-green-50 p-3 text-center sm:p-4">
                            <div className="text-lg font-bold text-green-600 sm:text-2xl">
                                {deviceInfo.screenWidth}x
                                {deviceInfo.screenHeight}
                            </div>
                            <div className="mt-1 text-xs text-gray-600 sm:text-sm">
                                Screen Size
                            </div>
                        </div>
                        <div className="rounded-lg bg-purple-50 p-3 text-center sm:p-4">
                            <div className="text-lg font-bold text-purple-600 sm:text-2xl">
                                {deviceInfo.pixelRatio}x
                            </div>
                            <div className="mt-1 text-xs text-gray-600 sm:text-sm">
                                Device Pixel Ratio
                            </div>
                        </div>
                        <div className="rounded-lg bg-orange-50 p-3 text-center sm:p-4">
                            <div className="text-lg font-bold text-orange-600 sm:text-2xl">
                                {deviceInfo.orientation}
                            </div>
                            <div className="mt-1 text-xs text-gray-600 sm:text-sm">
                                Orientation
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
