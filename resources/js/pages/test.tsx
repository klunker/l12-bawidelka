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
        <div className="min-h-screen bg-gray-100 p-8">
            <div className="mx-auto max-w-4xl">
                <h1 className="mb-8 text-3xl font-bold text-gray-800">
                    Device & Client Information
                </h1>

                <div className="grid gap-6 md:grid-cols-2">
                    {/* Device Resolution */}
                    <div className="rounded-lg bg-white p-6 shadow-md">
                        <h2 className="mb-4 text-xl font-semibold text-gray-700">
                            Device Resolution
                        </h2>
                        <div className="space-y-2">
                            <div className="flex justify-between">
                                <span className="text-gray-600">
                                    Screen Width:
                                </span>
                                <span className="font-mono font-medium">
                                    {deviceInfo.screenWidth}px
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">
                                    Screen Height:
                                </span>
                                <span className="font-mono font-medium">
                                    {deviceInfo.screenHeight}px
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">
                                    Window Width:
                                </span>
                                <span className="font-mono font-medium">
                                    {deviceInfo.windowWidth}px
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">
                                    Window Height:
                                </span>
                                <span className="font-mono font-medium">
                                    {deviceInfo.windowHeight}px
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">
                                    Pixel Ratio:
                                </span>
                                <span className="font-mono font-medium">
                                    {deviceInfo.pixelRatio}
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">
                                    Orientation:
                                </span>
                                <span className="font-mono font-medium">
                                    {deviceInfo.orientation}
                                </span>
                            </div>
                        </div>
                    </div>

                    {/* Client Information */}
                    <div className="rounded-lg bg-white p-6 shadow-md">
                        <h2 className="mb-4 text-xl font-semibold text-gray-700">
                            Client Information
                        </h2>
                        <div className="space-y-2">
                            <div className="flex justify-between">
                                <span className="text-gray-600">
                                    IP Address:
                                </span>
                                <span className="font-mono text-sm font-medium">
                                    {clientInfo.ip}
                                </span>
                            </div>
                            <div className="flex flex-col">
                                <span className="mb-1 text-gray-600">
                                    User Agent:
                                </span>
                                <span className="rounded bg-gray-50 p-2 font-mono text-xs break-all">
                                    {clientInfo.userAgent}
                                </span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">
                                    Accept Language:
                                </span>
                                <span className="font-mono text-sm font-medium">
                                    {clientInfo.acceptLanguage}
                                </span>
                            </div>
                            <div className="flex flex-col">
                                <span className="mb-1 text-gray-600">
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
                <div className="mt-6 rounded-lg bg-white p-6 shadow-md">
                    <h2 className="mb-4 text-xl font-semibold text-gray-700">
                        Browser Resolution
                    </h2>
                    <div className="grid grid-cols-2 gap-4 md:grid-cols-4">
                        <div className="rounded-lg bg-blue-50 p-4 text-center">
                            <div className="text-2xl font-bold text-blue-600">
                                {deviceInfo.windowWidth}x
                                {deviceInfo.windowHeight}
                            </div>
                            <div className="mt-1 text-sm text-gray-600">
                                Viewport Size
                            </div>
                        </div>
                        <div className="rounded-lg bg-green-50 p-4 text-center">
                            <div className="text-2xl font-bold text-green-600">
                                {deviceInfo.screenWidth}x
                                {deviceInfo.screenHeight}
                            </div>
                            <div className="mt-1 text-sm text-gray-600">
                                Screen Size
                            </div>
                        </div>
                        <div className="rounded-lg bg-purple-50 p-4 text-center">
                            <div className="text-2xl font-bold text-purple-600">
                                {deviceInfo.pixelRatio}x
                            </div>
                            <div className="mt-1 text-sm text-gray-600">
                                Device Pixel Ratio
                            </div>
                        </div>
                        <div className="rounded-lg bg-orange-50 p-4 text-center">
                            <div className="text-2xl font-bold text-orange-600">
                                {deviceInfo.orientation}
                            </div>
                            <div className="mt-1 text-sm text-gray-600">
                                Orientation
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
