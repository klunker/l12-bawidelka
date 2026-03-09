import { FileText } from 'lucide-react';
import type { Attachment } from '@/types/models';

export default function showAttachment(index: number, attachment: Attachment) {
    return (
        <a
           href={attachment.url}
           target="_blank"
           rel="noopener noreferrer"
           className="flex items-center gap-2 rounded-lg bg-gray-50 p-3 transition-colors hover:bg-gray-50/80"
        >
            <FileText className="h-5 w-5 text-primary" />
            <span className="font-medium">
                {attachment.name}
            </span>
        </a>
    );
}
